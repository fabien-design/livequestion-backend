<?php

namespace App\Controller\Api;

use App\Entity\Images;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/users')]
class UserController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $passwordHasher,
        private JWTTokenManagerInterface $jwtManager
    ) {}

    #[Route('/', name: 'app_api_user_index', methods: ['GET'], format: 'json')]
    public function index(
        UserRepository $userRepository,
        #[MapQueryParameter('pagination', filter: \FILTER_VALIDATE_BOOLEAN)] bool $pagination = false,
        #[MapQueryParameter('page', filter: \FILTER_VALIDATE_INT)] int $page = 1,
        #[MapQueryParameter('limit', filter: \FILTER_VALIDATE_INT)] int $limit = 10,
        #[MapQueryParameter(filter: \FILTER_VALIDATE_REGEXP, options: ['regexp' => '/^(asc|desc)$/'])] string $orderBy = 'DESC',
    ): Response {

        // $questions = $userRepository->PaginateQuestions(page: 1, limit: $limit, orderBy: strtoupper($orderBy), sortBy: $orderByField);
        if ($pagination) {
            $users = $userRepository->PaginateUsers(page: $page, limit: $limit, orderBy: strtoupper($orderBy));
        } else {
            $users = $userRepository->findAll();
        }

        $jsonQuestions = $this->serializer->serialize($users, 'json', ['groups' => 'user.index']);

        return new Response($jsonQuestions, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }

    #[Route("/new", name: 'app_api_user_new', methods: ['POST'], format: 'json')]
    public function new(Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $data = $request->request->all();
        $username = htmlspecialchars(strip_tags($data['username']));
        // Check if username or email already exists
        if ($userRepository->findOneBy(['username' => $username])) {
            return new Response(json_encode(['errors' => 'Username already exists']), Response::HTTP_BAD_REQUEST);
        }
        if (filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
            $errors = 'Invalid email';
            return new Response(json_encode(['errors' => $errors]), Response::HTTP_BAD_REQUEST);
        }
        $email = $data['email'];
        if (strlen($username) < 4 || strlen($username) > 50) {
            $errors = 'Username must be between 4 and 50 characters';
            return new Response(json_encode(['errors' => $errors]), Response::HTTP_BAD_REQUEST);
        }
        $password = htmlspecialchars(strip_tags(($data['password'])));


        $user = new User();
        $user->setUsername($username)
            ->setEmail($email)
            ->setPassword($this->passwordHasher->hashPassword($user, $password));

        if ($request->files->get('avatar')) {
            $maxFileSize = intval($this->getParameter('app.max_file_size')); // 5MB en octets
            $acceptedImageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/avif'];

            $avatar = $request->files->get('avatar');

            if (!in_array($avatar->getMimeType(), $acceptedImageTypes, true)) {
                return new Response(json_encode(['errors' => "Only .jpg, .jpeg, .png and .avif files are accepted."]), Response::HTTP_BAD_REQUEST);
            }
            if ($avatar->getSize() > $maxFileSize) {
                return new Response(json_encode(['errors' => `Max file size is 5MB. {$avatar->getSize()}`]), Response::HTTP_BAD_REQUEST);
            }


            $imageEntity = new Images();
            $imageEntity->setImageFile($avatar);
            $entityManager->persist($imageEntity);
            $user->setAvatar($imageEntity);
        }

        $entityManager->persist($user);
        try {
            $entityManager->flush();
            // Générer le token JWT
            $token = $this->jwtManager->createFromPayload($user, ['scope' => 'fileScope']);

            return new JsonResponse(['token' => $token], Response::HTTP_CREATED);
            // return new Response('User created', Response::HTTP_CREATED, ['Content-Type' => 'application/json']);

        } catch (\Exception $e) {
            return new Response('Error creating user', Response::HTTP_INTERNAL_SERVER_ERROR, ['Content-Type' => 'application/json']);
        }
    }

    #[Route('/bests', name: 'app_api_user_best', methods: ['GET'], format: 'json')]
    public function best(
        SerializerInterface $serializer,
        #[MapQueryParameter(filter: \FILTER_VALIDATE_INT)] int $limit = 5
    ): Response {
        $user = $this->userRepository->findBestUsers($limit);
        $jsonUser = $serializer->serialize($user, 'json', ['groups' => 'user.index']);
        return new Response($jsonUser, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }

    #[Route('/{username}', name: 'app_api_user_update', methods: ['POST'], format: 'json')]
    public function update(
        string $username,
        Request $request,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,
        JWTTokenManagerInterface $jwtManager,
        SerializerInterface $serializer
    ): Response {

        // Récupération du token depuis les en-têtes
        $authorizationHeader = $request->headers->get('Authorization');
        if (!$authorizationHeader) {
            return new Response(json_encode(['errors' => 'Token manquant']), Response::HTTP_UNAUTHORIZED);
        }

        // Extraction du token Bearer
        $token = str_replace('Bearer ', '', $authorizationHeader);
        $jwtPayload = $jwtManager->parse($token);

        // Vérification que le token appartient à l'utilisateur correct
        if ($jwtPayload['username'] !== $username) {
            return new Response(json_encode(['errors' => 'Token ne correspond pas à l’utilisateur']), Response::HTTP_UNAUTHORIZED);
        }

        // Validation du nom d'utilisateur
        if (empty($username) || !preg_match('/^[a-zA-Z0-9_ ]+$/', $username)) {
            return new Response(json_encode(['errors' => 'Nom d’utilisateur invalide']), Response::HTTP_BAD_REQUEST);
        }

        // Nettoyage et recherche de l'utilisateur
        $username = htmlspecialchars(strip_tags($username));
        $user = $userRepository->findOneBy(['username' => $username]);

        if (!$user) {
            return new Response(json_encode(['errors' => 'Utilisateur non trouvé']), Response::HTTP_NOT_FOUND);
        }

        // Traitement des données de la requête
        $data = $request->request->all();

        if (isset($data['username'])) {
            $newUsername = htmlspecialchars(strip_tags($data['username']));
            if (strlen($newUsername) < 4 || strlen($newUsername) > 50) {
                return new Response(json_encode(['errors' => 'Le nom d’utilisateur doit contenir entre 4 et 50 caractères']), Response::HTTP_BAD_REQUEST);
            }

            $existingUser = $userRepository->findOneBy(['username' => $newUsername]);
            if ($existingUser && $existingUser !== $user) {
                return new Response(json_encode(['errors' => 'Nom d’utilisateur déjà pris']), Response::HTTP_BAD_REQUEST);
            }
            $user->setUsername($newUsername);
        }
        if (isset($data['email'])) {
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                return new Response(json_encode(['errors' => 'Adresse e-mail invalide']), Response::HTTP_BAD_REQUEST);
            }
            $user->setEmail($data['email']);
        }

        if (isset($data['password'])) {
            $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);
            $user->setPassword($hashedPassword);
        }

        // Traitement de l'avatar
        if ($request->files->get('avatar')) {
            $maxFileSize = intval($this->getParameter('app.max_file_size')); // 5MB en octets
            $acceptedImageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/avif'];

            $avatar = $request->files->get('avatar');
            if (!in_array($avatar->getMimeType(), $acceptedImageTypes, true)) {
                return new Response(json_encode(['errors' => "Formats d'images acceptés: .jpg, .jpeg, .png et .avif."]), Response::HTTP_BAD_REQUEST);
            }
            if ($avatar->getSize() > $maxFileSize) {
                return new Response(json_encode(['errors' => "La taille maximale du fichier est de 5 Mo. Taille actuelle: {$avatar->getSize()}"]), Response::HTTP_BAD_REQUEST);
            }

            // Suppression de l'ancien avatar s'il existe
            $oldAvatar = $user->getAvatar();
            if ($oldAvatar) {
                $entityManager->remove($oldAvatar);
                $oldAvatarPath =  '/public/images/questions/' . $oldAvatar->getFilename();
                if (file_exists($oldAvatarPath)) {
                    unlink($oldAvatarPath);
                }
            }

            $imageEntity = new Images();
            $imageEntity->setImageFile($avatar);
            $entityManager->persist($imageEntity);
            $user->setAvatar($imageEntity);
        }

        $entityManager->persist($user);
        try {
            $entityManager->flush();
            // Générer le nouveau token JWT
            $token = $this->jwtManager->createFromPayload($user, ['scope' => 'fileScope']);
            $jsonUser = $serializer->serialize($user, 'json', ['groups' => 'user.show']);


            return new JsonResponse(['token' => $token, 'userDetails' => $jsonUser], Response::HTTP_OK, ['Content-Type' => 'application/json']);
        } catch (\Exception $e) {
            return new Response('Erreur lors de la mise à jour de l’utilisateur', Response::HTTP_INTERNAL_SERVER_ERROR, ['Content-Type' => 'application/json']);
        }
    }


    #[Route('/{username}', name: 'app_api_user_show', methods: ['GET'], format: 'json')]
    public function show(string $username, SerializerInterface $serializer): Response
    {
        // Validation et nettoyage du paramètre username
        if (empty($username) || !preg_match('/^[a-zA-Z0-9_ ]+$/', $username)) {
            // Retourner une réponse 400 Bad Request pour les requêtes mal formées
            return new Response('Invalid username parameter', Response::HTTP_BAD_REQUEST);
        }

        // Nettoyer le paramètre username pour éviter les problèmes de sécurité
        $username = htmlspecialchars(strip_tags($username));
        $user = $this->userRepository->findOneBy(['username' => $username]);
        // dd($user);
        $jsonUser = $serializer->serialize($user, 'json', ['groups' => 'user.show']);
        return new Response($jsonUser, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}

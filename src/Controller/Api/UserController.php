<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/users')]
class UserController extends AbstractController
{
    public function __construct(private SerializerInterface $serializer, private UserRepository $userRepository)
    {
    }

    #[Route('/', name: 'app_api_user_index', methods: ['GET'], format: 'json')]
    public function index(
        UserRepository $userRepository,
        // #[MapQueryParameter(filter: \FILTER_VALIDATE_REGEXP, options: ['regexp' => '/^(asc|desc)$/'])] string $orderBy = 'DESC',
        // #[MapQueryParameter(filter: \FILTER_VALIDATE_REGEXP, options: ['regexp' => '/^(date|answers)$/'])] string $orderByField = 'date',
        // #[MapQueryParameter(filter: \FILTER_VALIDATE_REGEXP, options: ['regexp' => '/^\d+$/'])] int $limit = 10,
    ): Response {
        $orderByFieldMapping = [
            'date' => 'createdAt',
            'answers' => 'answersCount',
        ];

        // $orderByField = $orderByFieldMapping[$orderByField] ?? 'createdAt';

        // $questions = $userRepository->PaginateQuestions(page: 1, limit: $limit, orderBy: strtoupper($orderBy), sortBy: $orderByField);

        $users = $userRepository->findAll();

        $jsonQuestions = $this->serializer->serialize($users, 'json', ['groups' => 'user.index']);

        return new Response($jsonQuestions, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }

    #[Route('/{username}', name: 'app_api_user_show', methods: ['GET'], format: 'json')]
    public function show(string $username, SerializerInterface $serializer): Response
    {
        // Validation et nettoyage du paramètre username
        if (empty($username) || !preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
            // Retourner une réponse 400 Bad Request pour les requêtes mal formées
            return new Response( 'Invalid username parameter', Response::HTTP_BAD_REQUEST);
        }

        // Nettoyer le paramètre username pour éviter les problèmes de sécurité
        $username = htmlspecialchars(strip_tags($username)); 
        $user = $this->userRepository->findOneBy(['username' => $username]);
        $jsonUser = $serializer->serialize($user, 'json', ['groups' => 'user.show']);
        return new Response($jsonUser, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }

    #[Route('/bests', name: 'app_api_user_best', methods: ['GET'], format: 'json')]
    public function best(SerializerInterface $serializer,
    #[MapQueryParameter(filter: \FILTER_VALIDATE_REGEXP, options: ['regexp' => '/^\d+$/'])] int $limit = 5): Response
    {

        $user = $this->userRepository->findBestUsers($limit);
        $jsonUser = $serializer->serialize($user, 'json', ['groups' => 'user.index']);
        return new Response($jsonUser, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}

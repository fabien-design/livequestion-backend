<?php

namespace App\Controller\Api;

use App\Entity\Images;
use App\Entity\Question;
use App\Form\QuestionType;
use App\Repository\CategoryRepository;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Image;
use Vich\UploaderBundle\Form\Type\VichImageType;

#[Route('/api/questions')]
class QuestionController extends AbstractController
{

    public function __construct(private SerializerInterface $serializer)
    {
    }

    #[Route('/', name: 'app_api_question_index', methods: ['GET'], format: 'json')]
    public function index(
        QuestionRepository $questionRepository,
        #[MapQueryParameter('page', filter: \FILTER_VALIDATE_INT)] int $page = 1,
        #[MapQueryParameter('limit', filter: \FILTER_VALIDATE_INT)] int $limit = 10,
        #[MapQueryParameter('orderBy', filter: \FILTER_VALIDATE_REGEXP, options: ['regexp' => '/^(asc|desc)$/i'])] string $orderBy = 'DESC',
        #[MapQueryParameter('w', filter: \FILTER_VALIDATE_REGEXP, options: ['regexp' => '/^(date|answers)$/'])] string $orderByField = 'date',
        #[MapQueryParameter('category', filter: \FILTER_VALIDATE_REGEXP, options: ['regexp' => '/^[a-zA-Z0-9]+$/'])] ?string $category = null,
        #[MapQueryParameter('author')] ?string $authorName = null,
        #[MapQueryParameter('random', filter: \FILTER_VALIDATE_BOOLEAN)] bool $random = false
    ): Response {
        $orderByFieldMapping = [
            'date' => 'createdAt',
            'answers' => 'answersCount',
        ];  

        $orderByField = $orderByFieldMapping[$orderByField] ?? 'createdAt';

        // Check if random is true, then override ordering parameters
        if ($random) {
            // Here we can set a specific random ordering or any logic related to random selection
            $orderByField = 'RAND()'; // or any random-specific field, depending on your database
            $orderBy = ''; // You might need to adjust this depending on your DBMS syntax
        }

        $questions = $questionRepository->PaginateQuestions(
            page: $page,
            limit: $limit,
            orderBy: strtoupper($orderBy),
            sortBy: $orderByField,
            category: $category,
            authorName: htmlspecialchars(strip_tags($authorName)),
        );

        $jsonQuestions = $this->serializer->serialize($questions, 'json', ['groups' => 'question.index']);

        return new Response($jsonQuestions, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }



    #[Route('/most-answers-last-three-days', name: 'app_api_question_most_answers_last_three_days', methods: ['GET'], format: 'json')]
    public function getQuestionWithMostAnswersLastThreeDays(
        QuestionRepository $questionRepository
    ): Response {
        $question = $questionRepository->findQuestionWithMostAnswersLastThreeDays();
        $jsonQuestions = $this->serializer->serialize($question, 'json', ['groups' => 'question.index']);
        return new Response($jsonQuestions, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }

    #[Route('/new', name: 'app_api_question_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository): Response
    {
        $token = $request->headers->get('Authorization');
        if (!$token) {
            throw new AccessDeniedException('Bearer token is missing');
        }

        $user = $this->getUser();
        $content = $request->request->get('content');
        $categoryId = intval($request->request->get('categoryId'));
        $category = $categoryRepository->find($categoryId);
        $question = new Question();
        $question->setAuthor($user);
        if($request->files->get('file') != null){
            $file = $request->files->get('file');
            $imageFile = new File($file);
            $fileName = md5(uniqid()). '.'. $imageFile->guessExtension();
            $image = new Images();
            $image->setName($fileName)
                ->setOriginalName($imageFile->getFilename())
                ->setExtension($imageFile->guessExtension())
                ->setSize($imageFile->getSize());

            $destination = $this->getParameter('kernel.project_dir').'/public/images/questions';
            $imageFile->move($destination, $fileName);
            $entityManager->persist($image);

            $question->setImages($image);
        } else {
            $question->setImages(null);
        }

        
        $question->setTitle($content)
        ->setCategory($category);

        $entityManager->persist($question);
        try {
            $entityManager->flush();
            return new Response('Question created', Response::HTTP_CREATED, ['Content-Type' => 'application/json']);
        } catch (\Exception $e) {
            // Handle exception and log error
            dd($e, $question);
            return new Response('Error creating question', Response::HTTP_INTERNAL_SERVER_ERROR, ['Content-Type' => 'application/json']);
        }
       
    }

    #[Route(
    path: '/{id}', 
    name: 'app_api_question_show', 
    methods: ['GET'], 
    format: 'json',
    )]
    public function show(Question $question,
    SerializerInterface $serializer,
    ): Response
    {
        if(!$question) {
            return new Response(null, Response::HTTP_NOT_FOUND, ['Content-Type' => 'application/json']);
        }
        $jsonQuestion = $serializer->serialize($question, 'json', ['groups' => 'question.show']);
        $response = new Response($jsonQuestion, Response::HTTP_OK, ['Content-Type' => 'application/json']);
        return $response;
    }

    #[Route('/{id}/edit', name: 'app_api_question_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Question $question, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_api_question_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('api/question/edit.html.twig', [
            'question' => $question,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_api_question_delete', methods: ['POST'])]
    public function delete(Request $request, Question $question, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $question->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($question);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_api_question_index', [], Response::HTTP_SEE_OTHER);
    }
}

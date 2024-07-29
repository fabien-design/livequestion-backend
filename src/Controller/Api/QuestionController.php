<?php

namespace App\Controller\Api;

use App\Entity\Question;
use App\Form\QuestionType;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/questions')]
class QuestionController extends AbstractController
{

    public function __construct(private SerializerInterface $serializer)
    {
    }

    #[Route('/', name: 'app_api_question_index', methods: ['GET'], format: 'json')]
    public function index(
        QuestionRepository $questionRepository,
        #[MapQueryParameter(filter: \FILTER_VALIDATE_REGEXP, options: ['regexp' => '/^(asc|desc)$/'])] string $orderBy = 'DESC',
        #[MapQueryParameter(filter: \FILTER_VALIDATE_REGEXP, options: ['regexp' => '/^(date|answers)$/'])] string $orderByField = 'date',
        #[MapQueryParameter(filter: \FILTER_VALIDATE_REGEXP, options: ['regexp' => '/^\d+$/'])] int $limit = 10,
    ): Response {
        $orderByFieldMapping = [
            'date' => 'createdAt',
            'answers' => 'answersCount',
        ];

        $orderByField = $orderByFieldMapping[$orderByField] ?? 'createdAt';

        $questions = $questionRepository->PaginateQuestions(page: 1, limit: $limit, orderBy: strtoupper($orderBy), sortBy: $orderByField);

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
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($question);
            $entityManager->flush();

            return $this->redirectToRoute('app_api_question_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('api/question/new.html.twig', [
            'question' => $question,
            'form' => $form,
        ]);
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

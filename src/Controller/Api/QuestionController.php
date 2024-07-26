<?php

namespace App\Controller\Api;

use App\Entity\Question;
use App\Form\QuestionType;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api')]
class QuestionController extends AbstractController
{

    public function __construct(private SerializerInterface $serializer) {}

    #[Route('/questions', name: 'app_api_question_index', methods: ['GET'])]
    public function index(QuestionRepository $questionRepository, ): Response
    {
        $questions = $questionRepository->findAll();
        $jsonQuestions = $this->serializer->serialize($questions, 'json', ['groups' => 'question:read']);

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

    #[Route('/{id}', name: 'app_api_question_show', methods: ['GET'])]
    public function show(Question $question): Response
    {
        return $this->render('api/question/show.html.twig', [
            'question' => $question,
        ]);
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
        if ($this->isCsrfTokenValid('delete'.$question->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($question);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_api_question_index', [], Response::HTTP_SEE_OTHER);
    }
}

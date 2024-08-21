<?php

namespace App\Controller\Api;

use App\Entity\Answer;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[Route('/api/answers')]
class AnswerController extends AbstractController
{
    // #[Route('/answer', name: 'app_answer')]
    // public function index(): Response
    // {
    //     return $this->render('answer/index.html.twig', [
    //         'controller_name' => 'AnswerController',
    //     ]);
    // }

    #[Route('/new', name: 'app_api_answer_new')]
    public function new(Request $request, QuestionRepository $questionRepository, EntityManagerInterface $entityManager): Response
    {
        $token = $request->headers->get('Authorization');
        if (!$token) {
            throw new AccessDeniedException('Bearer token is missing');
        }

        // Extract the token from the Authorization header
        $token = str_replace('Bearer ', '', $token);

        // Use the token to get the user
        $user = $this->getUser();
        $data = json_decode($request->getContent(), true);
        $content = htmlspecialchars(strip_tags($data['content']));
        $questionId = htmlspecialchars(strip_tags($data['questionId']));

        // Verify if the question exists
        $question = $questionRepository->find($questionId);
        if (!$question) {
            return new Response('Question not found', Response::HTTP_NOT_FOUND);
        }

        // Create the answer and associate it with the user and the question
        $answer = new Answer();
        $answer->setContent($content)
            ->setAuthor($user)
            ->setQuestion($question);
        $entityManager->persist($answer);
        $entityManager->flush();

        return new Response('Answer created', Response::HTTP_CREATED);
    }
}

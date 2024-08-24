<?php

namespace App\Controller\Api;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/categories')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'app_api_category_index', methods: ['GET'], format: 'json')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->json($categories, Response::HTTP_OK, [], ['groups' => 'category.index']);
    }
}   
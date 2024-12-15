<?php

namespace App\Controller;

use App\Repository\ProduktRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'product_list', methods: ['GET'])]
    public function list(ProduktRepository $ProduktRepository, Request $request): Response
    {
        $page = max(1, $request->query->getInt('page', 1));
        $limit = 20;
        $products = $ProduktRepository->findBy([], null, $limit, ($page - 1) * $limit);
        $totalProducts = $ProduktRepository->count([]);
        $totalPages = (int) ceil($totalProducts / $limit);

        return $this->render('products/list.html.twig', [
            'products' => $products,
            'currentPage' => $page,
            'totalPages' => $totalPages,
        ]);
    }
}
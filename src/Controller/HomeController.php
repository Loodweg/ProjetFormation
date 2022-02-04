<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(CategoryRepository $categoryRepository,ProductRepository $productRepository): Response
    {
        //Je vais chercher dans la bdd les categories
        $categories = $categoryRepository->findAll();

        //Je vais chercher les 8 derniers produits
        $products = $productRepository->findBy(
                [],
                [
                    'id' => 'DESC'
                ],
                6
            );

        //Je les envoie dans la vue
        return $this->render('customer/home.html.twig',[
            'categories' => $categories,
            'products' => $products
        ]);
    }
}
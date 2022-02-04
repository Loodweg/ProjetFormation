<?php 

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[Route('boutique/categorie/{id}', name: 'boutique_product_show_by_category')]
    public function showProductByCategory(int $id, CategoryRepository $categoryRepository)
    {
        $category = $categoryRepository->find($id);

        if(!$category)
        {
            return $this->redirectToRoute("home");
        }

        return $this->render("customer/product/show_by_category.html.twig",[
            'category' => $category
        ]);
    }

    #[Route('boutique/produit/{id}', name: 'boutique_product_detail')]
    public function detailProduct(int $id, ProductRepository $productRepository)
    {
        //je vais chercher un produit grace à l'id que j ai recu dans les parametres de l'url
        //Et avec l'aide du ProductRepo
        $product = $productRepository->find($id);

        //Si je le trouve pas en bdd
        //Je redirige directement vers la page d'accueil
        if(!$product)
        {
            return $this->redirectToRoute("home");
        }

        return $this->render("customer/product/detail_product.html.twig",[
            'product' => $product,
            
        ]);
    }

}
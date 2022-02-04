<?php 

namespace App\Controller;

use App\Services\Cart\HandleCart;
use App\Repository\ProductRepository;
use App\Services\Cart\CartRealProduct;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CartController extends AbstractController
{
    #[Route('/panier/ajouter/{id}', name: 'cart_add')]
    public function add(int $id, ProductRepository $productRepository,HandleCart $handleCart,Request $request)
    {
        $product = $productRepository->find($id);

        if(!$product)
        {
             return $this->redirectToRoute("home");
        }

        $handleCart->add($id);

        $this->addFlash("success","Le produit a bien été ajouté au panier");

        if($request->query->get('routeToRedirect') === 'panier')
        {
            return $this->redirectToRoute("cart_detail");
        }
        else
        {
            return $this->redirectToRoute("boutique_product_detail",['id'=> $id]);
        }
    }

    #[Route('/panier/detail', name: 'cart_detail')]
    public function detailCart(HandleCart $handleCart)
    {
        //Je créé un tableau qui va représenter le produit réel et la quantité associée
        $detailProducts = $handleCart->detailPanier();

        //J'initialise un total à 0
        $total = $handleCart->getTotalPanier();

        return $this->render("customer/panier.html.twig",[
            'detailProducts' => $detailProducts,
            'totalPrixPanier' => $total
        ]);
    }

    #[Route('/panier/supprimerproduit/{id}', name: 'cart_remove_product')]
    public function deleteItemCart(int $id,HandleCart $handleCart)
    {
        $handleCart->removeItem($id);

        $this->addFlash("info","Le produit a bien été retiré du panier");
        return $this->redirectToRoute("cart_detail");
    }

    #[Route('/panier/decrementer/{id}', name: 'cart_decrement_product')]
    public function decrementItemCart(int $id,HandleCart $handleCart)
    {
        $handleCart->decrementItem($id);

        $this->addFlash("info","Le produit a bien été décrémenté");
        return $this->redirectToRoute("cart_detail");

    }


}
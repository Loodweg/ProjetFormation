<?php 

namespace App\Services\Cart;

use App\Repository\ProductRepository;
use App\Services\Cart\CartItem;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class HandleCart
{
    private $session;

    private $productRepository;

    public function __construct(SessionInterface $session,ProductRepository $productRepository)
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
    }

    private function getCart()
    {
        return $this->session->get('cart',[]);
    }

    private function saveCart($cart)
    {
        $this->session->set('cart',$cart);
    }

    public function add($id)
    {
        $cart = $this->getCart();

        foreach($cart as $item)
        {
            if($item->getId() === $id)
            {
                $qtyActual = $item->getQty();
                $newQty = $qtyActual + 1;

                $item->setQty($newQty);

                $this->saveCart($cart);

                return;
            }
        }

        $cartItem = new CartItem();
        $cartItem->setId($id);
        $cartItem->setQty(1);

        $cart[] = $cartItem;

        $this->saveCart($cart);
    }

    public function detailPanier()
    {
        //Je créé un tableau qui va représenter le produit réel et la quantité associée
        $detailProducts = [];

        //Je vais chercher mon panier dans la session
        $cart = $this->getCart();

        //Je boucle sur tous les elements de mon paniers

        foreach($cart as $item)
        {
            //Je vais chercher le produit dans la bdd
            //Grace a l'id qui dans l'item du panier
            $product = $this->productRepository->find($item->getId());
            
            //Je cree une classe qui va contenir mon produit reel
            //Et la quantité associé
            $cartRealProduct = new CartRealProduct();
            $cartRealProduct->setProduct($product);
            $cartRealProduct->setQty($item->getQty());

            //J'ajoute cet objet cartRealProduct dans le tableau
            //Que je vais envoyer a la vue
            $detailProducts[] = $cartRealProduct;
        }

        return $detailProducts;
    }

    public function getTotalPanier()
    {
        $cart = $this->getCart();

        //J'initialise un total à 0
        $total = 0;

        //Je boucle sur mes articles du panier 
        //Pour augmenter le prix total
        foreach($cart as $item)
        {
            $product = $this->productRepository->find($item->getId());

            $prixItem = $product->getPrice() * $item->getQty();

            $total +=  $prixItem;
        }

        return $total;
    }

    public function removeItem($id)
    {
        $cart = $this->getCart();

        foreach($cart as $key => $item)
        {
            if($item->getId() === $id)
            {
                unset($cart[$key]);
                $this->saveCart($cart);
                return;
            }
        }
    }

    public function decrementItem($id)
    {
        //je cherche mon panier
        $cart = $this->getCart();

        //je boucle sur les elements du panier
        foreach($cart as $key => $item)
        {
            
            if($item->getId() === $id)
            {
                //Je check si la quantité est égale à 1
                $qty = $item->getQty();

                if($qty === 1)
                {
                    unset($cart[$key]);
                    $this->saveCart($cart);
                    return;
                }
                else 
                {
                    $item->setQty($qty - 1);
                    $this->saveCart($cart);
                    return;
                }
            }
        }
    }

    public function emptyCart()
    {
        $this->saveCart([]);
    }
}
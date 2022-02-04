<?php 

namespace App\Controller\Purchase;

use Stripe\Stripe;
use App\Entity\User;
use Stripe\Checkout\Session;
use App\Services\Cart\HandleCart;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeController extends AbstractController
{

    #[Route('/boutique/commande/stripe/session', name: 'boutique_stripe_session')]
    public function createSession(HandleCart $handleCart)
    {
        Stripe::setApiKey('sk_test_51KP6IzCw94ZAL33wRx5P7nP9RDCZM5jtmdufRctbzUOP4p6VE6kv5cBQVP5xpwnxYyUIfNXUFXuV1hCarINKqwIp003pGdzjUP');
        
        $YOUR_DOMAIN = 'http://localhost:8000';

        /** @var User $user */
        $user = $this->getUser();

        $productsDetail = $handleCart->detailPanier();

        $productForStripe = [];

        foreach($productsDetail as $item)
        {
            $productForStripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $item->getProduct()->getPrice(),
                    'product_data' => [
                        'name' => $item->getProduct()->getName(),
                        'images' => [
                           $item->getProduct()->getImagePath()
                        ]
                    ]
                ],
                'quantity' => $item->getQty()
            ];
        }



        $checkout_session = Session::create([
            'customer_email' => $user->getEmail(),
            'payment_method_types' => [
                'card',
            ],
            'line_items' => [
                $productForStripe
            ],
            'mode' => 'payment',
              'success_url' => $YOUR_DOMAIN . '/boutique/paiement/success',
              'cancel_url' => $YOUR_DOMAIN . '/boutique/paiement/cancel',
          ]);

        return $this->redirect($checkout_session->url);

    }
}
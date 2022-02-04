<?php 

namespace App\Controller\Purchase;

use App\Entity\ContentInvoice;
use App\Entity\Invoice;
use App\Repository\PurchaseRepository;
use App\Services\Cart\HandleCart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PaymentResultController extends AbstractController
{
    #[Route('/boutique/paiement/success', name: 'boutique_payment_success')]
    public function success( PurchaseRepository $purchaseRepository,HandleCart $handleCart,EntityManagerInterface $em)
    {
        $user = $this->getUser();

        $purchase = $purchaseRepository->findOneBy(
            [
                'user' => $user
            ],
            [
                'id' => 'DESC'
            ]
        );

        $invoice = new Invoice();

        $invoice->setPurchase($purchase);
        $invoice->setIsPayed(1);
        $invoice->setTotal($handleCart->getTotalPanier());

        $em->persist($invoice);

        $productsDetail = $handleCart->detailPanier();

        foreach($productsDetail as $item)
        {
           $contentInvoice = new ContentInvoice();

           $contentInvoice->setImageProduct($item->getProduct()->getImagePath());
           $contentInvoice->setInvoice($invoice);
           $contentInvoice->setPriceProduct($item->getProduct()->getPrice());
           $contentInvoice->setProductName($item->getProduct()->getName());
           $contentInvoice->setQuantity($item->getQty());

           $em->persist($contentInvoice);
        }

        $em->flush();

        $handleCart->emptyCart();

        return $this->render("customer/purchase/thank_you.html.twig");
    }

    #[Route('/boutique/paiement/cancel', name: 'boutique_payment_cancel')]
    public function cancel()
    {
        $this->addFlash("info","Le paiement a été refusé. Vous pouvez essayer un autre moyen de paiement.");
        return $this->redirectToRoute("boutique_commande_recap");
    }
}
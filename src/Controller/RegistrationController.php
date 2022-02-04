<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        //Je cree une instance de la classe user
        $user = new User();

        //Je cree mon formulaire d inscription
        $form = $this->createForm(RegistrationFormType::class, $user);

        //Je gere la requete et les infos du formulaire
        $form->handleRequest($request);

        //Si le formulaire a ete soumis
        if ($form->isSubmitted() && $form->isValid()) {

            // Je hash le password avant de l'envoyer en base de données
            $user->setPassword(
                //J'utilise le composant UserPasswordHasherInterface
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            //J'utilise le entity manager pour persister le user
            $entityManager->persist($user);
            //Je fais un flush pour finaliser l'envoi du nouveau user dans la bdd
            $entityManager->flush();
            // do anything else you need here, like send an email

            //Je redirige vers la page de login
            return $this->redirectToRoute('app_login');
        }

        //Si je viens d'arriver sur la page, on affiche la vue
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}

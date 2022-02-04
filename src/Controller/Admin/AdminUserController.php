<?php 

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminUserController extends AbstractController
{
    #[Route('/admin/user/list', name: 'admin_user_list')]
    public function listUser(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();

        return $this->render("admin/user/list.html.twig",[
            'users' => $users
        ]);
    }  
    #[Route('/admin/user/togglerole/{id}', name: 'admin_user_toggle_role')]
    public function toggleRole(int $id,UserRepository $userRepository,EntityManagerInterface $em)
    {
        //Je vais chercher en bdd le user correspondant à l'id envoyé
        $user = $userRepository->find($id);

        //Si il existe pas, je renvoi un message d'erreur
        if(!$user)
        {
            $this->addFlash("danger","Utilisateur introuvable.");
            return $this->redirectToRoute("admin_user_list");
        }

        //Je vais chercher le role actuel du user
        $role = $user->getRoles()[0];

        //Si son role actuel est admin , je lui attribue plus aucun role
        if($role === "ROLE_ADMIN")
        {
            $user->setRoles([]);
        }
        //Si son role actuel n'est pas ADMIN, alors je lui donne le role admin
        else
        {
            $user->setRoles(["ROLE_ADMIN"]);
        }

        //Grace au Entity Manager , j'envoie cette modification en bdd
        $em->flush();

        //Ensuite je renvoie un message flash
        $this->addFlash("success","Le rôle du user : " . $user->getEmail() . " a bien été modifié.");

        //Je redirige vers la liste des users
        return $this->redirectToRoute("admin_user_list");
    } 
}
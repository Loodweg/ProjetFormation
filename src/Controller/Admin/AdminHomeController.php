<?php

namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AdminHomeController extends AbstractController
{
    #[Route('/admin/home', name: 'admin_home')]
    public function home() : Response
    {
        return $this->render("admin/home.html.twig");
    }
}


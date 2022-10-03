<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class AdminController extends AbstractController
{

    #[Route('/campus', name:'campus')]
    public function campus(): Response
    {
        return $this->render('admin/campus/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Ville;
use App\Repository\VilleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class AdminController extends AbstractController
{
    #[Route('/campus', name:'campus')]
    public function campus(): Response
    {
        return $this->render('admin/campus/campus.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/villes', name: 'villes')]
    public function villes(VilleRepository $villeRepository) : Response {
        $villeRepository = $villeRepository->findAll();


        return $this->render('admin/villes/villes.html.twig', ['villes' => $villeRepository]);
    }
}

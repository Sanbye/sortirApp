<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnulerSortieController extends AbstractController
{
    #[Route('sortie/annuler/sortie', name: 'app_annuler_sortie')]
    public function AnnulerSortie(): Response
    {
        return $this->render('annuler_sortie/index.html.twig', [
            'controller_name' => 'AnnulerSortieController',
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AfficherSortieController extends AbstractController
{
    #[Route('sortie/afficher/sortie', name: 'app_afficher_sortie')]
    public function afficherSortie(): Response
    {
        return $this->render('afficher_sortie/index.html.twig', [
            'controller_name' => 'AfficherSortieController',
        ]);
    }
}

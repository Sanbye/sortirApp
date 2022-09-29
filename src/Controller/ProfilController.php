<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function afficher(): Response
    {
        return $this->render('profil/afficher.html.twig', [
            'controller_name' => 'ProfilController',
        ]);
    }

    #[Route('/profil/modifier', name: 'app_profil_modifier')]
    public function modifier(): Response
    {
        return $this->render('profil/afficher.html.twig', [
            'controller_name' => 'ProfilController',
        ]);
    }
}

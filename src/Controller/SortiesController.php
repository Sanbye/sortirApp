<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortiesController extends AbstractController
{
    #[Route('/sorties', name: 'app_sorties')]
    public function afficher(): Response
    {
        return $this->render('sorties/', [
            'controller_name' => 'SortiesController',
        ]);
    }

    #[Route('/sorties/creer', name: 'app_sorties_creer')]
    public function creer(): Response
    {
        return $this->render('sorties/', [
            'controller_name' => 'SortiesController',
        ]);
    }

    #[Route('/sorties/modifier', name: 'app_sorties_modifier')]
    public function modifier(): Response
    {
        return $this->render('sorties/', [
            'controller_name' => 'SortiesController',
        ]);
    }

    #[Route('/sorties/annuler', name: 'app_sorties_annuler')]
    public function annuler(): Response
    {
        return $this->render('sorties/', [
            'controller_name' => 'SortiesController',
        ]);
    }
}

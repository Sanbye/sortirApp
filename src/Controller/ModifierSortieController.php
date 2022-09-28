<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModifierSortieController extends AbstractController
{
    #[Route('sortie/modifier/sortie', name: 'app_modifier_sortie')]
    public function modifierSortie(): Response
    {
        return $this->render('modifier_sortie/index.html.twig', [
            'controller_name' => 'ModifierSortieController',
        ]);
    }
}

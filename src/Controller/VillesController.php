<?php

namespace App\Controller;

use App\Entity\Ville;
use App\Form\VillesType;
use App\Repository\VilleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/villes', name: 'villes_')]
class VillesController extends AbstractController
{
    #[Route('', name: 'afficher')]
    public function Afficher(VilleRepository $villeRepository) : Response {
        $repo = $villeRepository->findAll();

        $villes = new Ville();
        $villesForm = $this->createForm(VillesType::class, $villes);

        return $this->render('villes/villes.html.twig', ['villes' => $repo, 'villesForm' => $villesForm->createView()]);
    }
}

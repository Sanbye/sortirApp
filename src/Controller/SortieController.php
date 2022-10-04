<?php

namespace App\Controller;

use App\Repository\SerieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/sorties', name: 'sortie_')]
class SortieController extends AbstractController
{
    #[Route('/modifier', name: 'modifier')]
    public function update(SortieRepository $sortieRepository): Response
    {
        //$sorties = $sortieRepository->findAll();

        return $this->render('sortie/update.html.twig', [
            //'sorties' => $sorties,
        ]);
    }

    #[Route('/creer', name: 'creer')]
    public function create(SortieRepository $sortieRepository): Response
    {
        //$sorties = $sortieRepository->findAll();

        $sortie = new Sortie();
        $sortieForm = $this->createForm(SortieType::class, $sortie);

        return $this->render('sortie/creer.html.twig', ['sortieForm' => $sortieForm->createView()]);
    }
}

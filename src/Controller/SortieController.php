<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\CreateSortieType;
use App\Form\SortiesFormType;
use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/sorties', name: 'sortie_')]
class SortieController extends AbstractController
{
    #[Route('/modifier', name: 'modifier')]
    public function update(SortieRepository $sortieRepository): Response
    {
        return $this->render('sorties/modifier.html.twig',);
    }

    #[Route('/creer', name: 'creer')]
    public function create(SortieRepository $sortieRepository): Response
    {
        $sorties = new Sortie();
        $sortiesForm = $this->createForm(CreateSortieType::class, $sorties);

        return $this->render('sorties/creer.html.twig', [ 'sortiesForm' => $sortiesForm->createView()]);
    }

    #[Route('/annuler', name: 'annuler')]
    public function cancel(SortieRepository $sortieRepository): Response
    {
        $sortiesForm = $this->createForm(SortiesFormType::class);

        return $this->render('sorties/annuler.html.twig', ['sortiesForm' => $sortiesForm->createView()]);
    }
}

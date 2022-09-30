<?php

namespace App\Controller;

use App\Repository\SerieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('sorties', name: 'sortie_')]
class SortieController extends AbstractController
{
    #[Route('', name: 'list')]
    public function list(): Response
    {
        //$sorties = $sortieRepository->findAll();

        return $this->render('sortie/list.html.twig', [
           // 'sorties' => $sorties,
        ]);
    }

    #[Route('/update/{id}', name: 'update')]
    public function update(int $id,SortieRepository $sortieRepository): Response
    {
        //$sorties = $sortieRepository->findAll();

        return $this->render('sortie/update.html.twig', [
            //'sorties' => $sorties,
        ]);
    }

    #[Route('/{id}', name: 'info')]
    public function selectBy(int $id,SortieRepository $sortieRepository): Response
    {
        //$sorties = $sortieRepository->findAll();

        return $this->render('selectBy/update.html.twig', [
            //'sorties' => $sorties,
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(SortieRepository $sortieRepository): Response
    {
        //$sorties = $sortieRepository->findAll();

        return $this->render('sortie/update.html.twig', [
            //'sorties' => $sorties,
        ]);
    }
    #[Route('/delete/{id}', name: 'delete')]
    public function delete(int $id,SortieRepository $sortieRepository): Response
    {
        //$sorties = $sortieRepository->findAll();

        return $this->render('sortie/update.html.twig', [
            //'sorties' => $sorties,
        ]);
    }



}

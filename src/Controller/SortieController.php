<?php

namespace App\Controller;

use App\Form\AnnulerSortieFormType;
use App\Repository\EtatRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/afficher/{id}',name: 'afficher')]
    public function afficher(int $id, SortieRepository $sortieRepository): Response
    {
        $sortie = $sortieRepository->find($id);

        return $this->render('sorties/afficher.html.twig', ['sortie' => $sortie]);
    }

    #[Route('/annuler/{id}',name: 'annuler')]
    public function annuler(int $id, EtatRepository $etatRepository ,SortieRepository $sortieRepository,Request $request, EntityManagerInterface $entityManager): Response
    {
        $sortie = $sortieRepository->find($id);
        $annulerForm = $this->createForm(AnnulerSortieFormType::class, $sortie);
        $annulerForm->handleRequest($request);

        if($annulerForm->isSubmitted() && $annulerForm->isValid()){

            $sortie->setEtat($etatRepository->findOneBy(["libelle" => 'annulée']));

            $entityManager->persist($sortie);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

    return $this->render('sorties/annuler.html.twig', ['annulerForm' => $annulerForm->createView(),'sortie' => $sortie]);

    }
}

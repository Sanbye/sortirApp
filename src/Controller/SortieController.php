<?php

namespace App\Controller;

use App\Form\AnnulerSortieFormType;
use App\Repository\EtatRepository;
use App\Repository\SortieRepository;
use App\Entity\Sortie;
use App\Form\CreateFormSortie;
use App\Form\CreateSortieType;
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
        return $this->render('sorties/modifier.html.twig',);
    }

    #[Route('/creer', name: 'creer')]
    public function create(Request $request, EntityManagerInterface $entityManager, EtatRepository $etatRepository): Response
    {
        //$sorties = $sortieRepository->findAll();

        $sorties = new Sortie();
        $sorties
            ->setOrganisateur($this->getUser())
            ->setCampus($this->getUser()->getCampus());

        $sortiesForm = $this->createForm(CreateSortieType::class, $sorties);

        $sortiesForm->handleRequest($request);

        if ($sortiesForm->isSubmitted() && $sortiesForm->isValid()) {

            if ($sortiesForm->get('enregistrer')->isClicked()) {
                $sorties->setEtat($etatRepository->findOneBy(["libelle" => 'créée']));
            } elseif ($sortiesForm->get('publier')->isClicked()) {
                $sorties->setEtat($etatRepository->findOneBy(["libelle" => 'ouverte']));
            }

            $entityManager->persist($sorties);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('sorties/creer.html.twig', [
            'sortiesForm' => $sortiesForm->createView()
        ]);
    }

    #[Route('/afficher/{id}', name: 'afficher')]
    public function afficher(int $id, SortieRepository $sortieRepository): Response
    {
        $sortie = $sortieRepository->find($id);

        return $this->render('sorties/afficher.html.twig', ['sortie' => $sortie]);
    }

    #[Route('/annuler/{id}', name: 'annuler')]
    public function annuler(int $id, EtatRepository $etatRepository, SortieRepository $sortieRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $sortie = $sortieRepository->find($id);
        $annulerForm = $this->createForm(AnnulerSortieFormType::class, $sortie);
        $annulerForm->handleRequest($request);

        if ($annulerForm->isSubmitted() && $annulerForm->isValid()) {

            $sortie->setEtat($etatRepository->findOneBy(["libelle" => 'annulée']));

            $entityManager->persist($sortie);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('sorties/annuler.html.twig', ['annulerForm' => $annulerForm->createView(), 'sortie' => $sortie]);
    }
}

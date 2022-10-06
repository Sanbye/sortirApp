<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Entity\Ville;
use App\Entity\Lieu;
use App\Form\AnnulerSortieFormType;
use App\Form\CreateFormSortie;
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
        return $this->render('sorties/modifier.html.twig',);
    }

    #[Route('/creer', name: 'creer')]
    public function create(Request $request, EntityManagerInterface $entityManager, EtatRepository $etatRepository): Response
    {
        //$sorties = $sortieRepository->findAll();
        $lieu = new Lieu();
        $ville = new Ville();

        $sortie = new Sortie();
        $sortieCreateForm = $this->createForm(CreateFormSortie::class, $sortie);

        $sortieCreateForm->handleRequest($request);

        if ($sortieCreateForm->isSubmitted() && $sortieCreateForm->isValid()) {

            $sortie->setCampus($this->getUser()->getCampus());

            if ($sortieCreateForm->get('enregistrer')->isClicked()) {
                $sortie->setEtat($etatRepository->findOneBy(["libelle" => 'créée']));
            } elseif ($sortieCreateForm->get('publier')->isClicked()) {
                $sortie->setEtat($etatRepository->findOneBy(["libelle" => 'ouverte']));
            }

            $sortie->setOrganisateur($this->getUser());
            $entityManager->persist($sortie);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('sorties/creer.html.twig', [
            'lieu' => $lieu,
            'ville' => $ville,
            'sortieCreateForm' => $sortieCreateForm->createView()
        ]);
    }

    #[Route('/afficher/{id}', name: 'afficher')]
    public function afficher(int $id, SortieRepository $sortieRepository): Response
    {
        $sortie = $sortieRepository->find($id);

        return $this->render('sorties/afficher.html.twig', ['sortie' => $sortie]);
    }

    #[Route('/annuler/{id}', name: 'annuler')]
    public function annuler(
        int $id,
        EtatRepository $etatRepository,
        SortieRepository $sortieRepository,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
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

    #[Route('/desister/{id}', name: 'desister')]
    public function desister(int $id, EntityManagerInterface $entityManager): Response
    {
        $sortieRepo = $entityManager->getRepository(Sortie::class);
        $sortie = $sortieRepo->find($id);

        $entityManager->remove($this->getUser());
        $entityManager->flush($sortie);

        $this->addFlash('Succes', 'Vous vous êtes bien désisté !');

        return $this->redirectToRoute('home');
    }
}

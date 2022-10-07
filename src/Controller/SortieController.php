<?php

namespace App\Controller;

use App\Form\AnnulerSortieFormType;
use App\Form\CreateFormSortie;
use App\Repository\EtatRepository;
use App\Repository\ParticipantRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/sorties', name: 'sortie_')]
class SortieController extends AbstractController
{
    #[Route('/publier/{id}', name: 'publier')]
    public function publier(int $id, SortieRepository $sortieRepository, EtatRepository $etatRepository, EntityManagerInterface $entityManager)
    {

        $sortie = $sortieRepository->find($id);

        $sortie->setEtat($etatRepository->findOneBy(["libelle" => 'ouverte']));
        $entityManager->persist($sortie);
        $entityManager->flush();

        return $this->redirectToRoute('home');

    }

    #[Route('/modifier/{id}', name: 'modifier')]
    public function update(int $id,
                            SortieRepository $sortieRepository,
                            Request $request,
                            EntityManagerInterface $entityManager,
                            EtatRepository $etatRepository): Response
    {
       $sortie = $sortieRepository->find($id);
       $sortieCreateForm = $this->createForm(CreateFormSortie::class, $sortie);

        $sortieCreateForm->handleRequest($request);

        if ($sortieCreateForm->isSubmitted() && $sortieCreateForm->isValid()) {

            if ($sortieCreateForm->get('enregistrer')->isClicked()) {

                $sortie->setEtat($etatRepository->findOneBy(["libelle" => 'créée']));
            } elseif ($sortieCreateForm->get('publier')->isClicked()) {

                $sortie->setEtat($etatRepository->findOneBy(["libelle" => 'ouverte']));
            }


            $entityManager->persist($sortie);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render(
            'sorties/modifier.html.twig', [
                'sortieCreateForm' => $sortieCreateForm->createView(),
            'sortie' => $sortie
            ]);
    }

    #[Route('/creer', name: 'creer')]
    public function create(Request $request,
                           EntityManagerInterface $entityManager,
                           EtatRepository $etatRepository,
                           ParticipantRepository $participantRepository): Response
    {
        //$sorties = $sortieRepository->findAll();

        $sortie = new Sortie();
        $participant = $participantRepository->find($this->getUser());
        $sortie->setOrganisateur($participant);

        $sortieCreateForm = $this->createForm(CreateFormSortie::class, $sortie);

        $sortieCreateForm->handleRequest($request);

        if ($sortieCreateForm->isSubmitted() && $sortieCreateForm->isValid()) {

            $sortie->setCampus($this->getUser()->getCampus());

            if ($sortieCreateForm->get('enregistrer')->isClicked()) {

                $sortie->setEtat($etatRepository->findOneBy(["libelle" => 'créée']));
            } elseif ($sortieCreateForm->get('publier')->isClicked()) {

                $sortie->setEtat($etatRepository->findOneBy(["libelle" => 'ouverte']));

            }


            $entityManager->persist($sortie);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('sorties/creer.html.twig', [
            'sortieCreateForm' => $sortieCreateForm->createView()
        ]);
    }

    #[Route('/inscrit/{id}', name: 'inscription')]
    public function inscription(int $id, Request $request, EntityManagerInterface $entityManager, SortieRepository $sortieRepository): Response
    {
        $sortie = $sortieRepository->find($id);
        $participant = $this->getUser();

        $sortie->addParticipant($participant);

        $entityManager->persist($sortie);
        $entityManager->flush();

        return $this->redirectToRoute('home');
    }

    #[Route('/désisté/{id}', name: 'désinscription')]
    public function desinscription(int $id, Request $request, EntityManagerInterface $entityManager, SortieRepository $sortieRepository): Response
    {
        $sortie = $sortieRepository->find($id);
        $participant = $this->getUser();

        $sortie->removeParticipant($participant);

        $entityManager->persist($sortie);
        $entityManager->flush();

        return $this->redirectToRoute('home');
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

    #[Route('/supprimer/{id}', name: 'supprimer')]
    public function supprimer(int $id, EtatRepository $etatRepository, SortieRepository $sortieRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $sortie = $sortieRepository->find($id);
        $entityManager->remove($sortie);
        $entityManager->flush();


        return $this->redirectToRoute('home');

    }
}

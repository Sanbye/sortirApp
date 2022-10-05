<?php

namespace App\Controller;

use App\Entity\Sortie;
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
    public function update(): Response
    {
        return $this->render('sorties/modifier.html.twig',);
    }

    #[Route('/creer', name: 'creer')]
    public function create(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {

        $sorties = new Sortie();
        $organisateur = $this->getUser();

        $sortiesForm = $this->createForm(CreateSortieType::class, $sorties);
        $sortiesForm->handleRequest($request);

        if ($sortiesForm->isSubmitted() && $sortiesForm->isValid()) {

            $entityManager->persist($sorties);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('sorties/creer.html.twig', [
            'organisateur' => $organisateur,
            'sortiesForm' => $sortiesForm->createView()
        ]);
    }

    #[Route('/annuler', name: 'annuler')]
    public function cancel(): Response
    {
        return $this->render('sorties/annuler.html.twig');
    }
}

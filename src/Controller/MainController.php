<?php

namespace App\Controller;

use App\Form\ProfilFormType;
use App\Form\SortiesFormType;
use App\Repository\ParticipantRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(ParticipantRepository $participantRepository,
                         SortieRepository      $sortieRepository,
                         Request $request,
                         EntityManagerInterface $entityManager): Response
    {
        $participant = $this->getUser();


        //foreach($sorties->getParticipants() as $participants) {
        //    $nbParticipants = $participants.length;
        //}

        // PENSER A CREER UNE CLASSE FILTRE POUR RECUP
        $sortiesForm = $this->createForm(SortiesFormType::class);

        $sortiesForm->handleRequest($request);
        $sorties = $sortieRepository->findAll();
        //A REMPLACER PAR UNE REQUETE PERSONNALISEE POUR NOS FILTRES -




            return $this->render('main/index.html.twig', [
                'participant' => $participant,
                'sorties' => $sorties,
                'sortiesForm' => $sortiesForm->createView(),
            ]);


    }
}

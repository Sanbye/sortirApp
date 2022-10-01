<?php

namespace App\Controller;

use App\Repository\ParticipantRepository;
use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


#[Route('/', name: 'participant_')]
class ParticipantController extends AbstractController
{

    #[Route('home', name: 'home')]
    public function home(ParticipantRepository $participantRepository,
                        SortieRepository $sortieRepository
    ): Response
    {
        $participant = $this->getUser();
        $sorties = $sortieRepository->findAll();


        //foreach($sorties->getParticipants() as $participants) {
        //    $nbParticipants = $participants.length;
        //}


        return $this->render('main/index.html.twig', [
            'controller_name' => 'ParticipantController',
            'participant' => $participant,
            'sorties' => $sorties,
        ]);
    }

    #[Route('profil', name: 'profil')]
    public function afficherProfil(ParticipantRepository $participantRepository): Response
    {
        $participant = $this->getUser();

        return $this->render('profil/profil.html.twig', [
            'participant' => $participant,
        ]);
    }




    #[Route('update', name: 'update')]
    public function modifierProfil(): Response
    {
        return $this->render('participant/update.html.twig', [
            'controller_name' => 'ParticipantController',
        ]);
    }
}

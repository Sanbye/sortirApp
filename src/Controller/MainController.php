<?php

namespace App\Controller;

use App\Repository\ParticipantRepository;
use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('home', name: 'home')]
    public function home(ParticipantRepository $participantRepository,
                         SortieRepository      $sortieRepository
    ): Response
    {
        $participant = $this->getUser();
        $sorties = $sortieRepository->findAll();

        //foreach($sorties->getParticipants() as $participants) {
        //    $nbParticipants = $participants.length;
        //}

        return $this->render('participant/index.html.twig', [
            'controller_name' => 'ParticipantController',
            'participant' => $participant,
            'sorties' => $sorties,
        ]);
    }
}

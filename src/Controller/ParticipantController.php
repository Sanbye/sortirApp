<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\ProfilType;
use App\Repository\ParticipantRepository;
use App\Repository\SortieRepository;
use http\Client\Curl\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


#[Route('/', name: 'participant_')]
class ParticipantController extends AbstractController
{

    #[Route('update', name: 'update')]
    public function modifierProfil(): Response
    {
        return $this->render('', [
            'controller_name' => 'ParticipantController',
        ]);
    }
}

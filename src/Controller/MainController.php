<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function create(Request $request): Response
    {
        $Participant = new Participant();
        $ParticipantForm = $this->createForm(LoginType::class, $Participant);
        $ParticipantForm->handleRequest($request);

        if ($ParticipantForm->isSubmitted() && $ParticipantForm->isValid()) {
            $this->redirectToRoute('/home');
        }

        return $this->render('main/index.html.twig', ["ParticipantForm" => $ParticipantForm->createView()]);
    }
}

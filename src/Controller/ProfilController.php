<?php
namespace App\Controller;
use App\Entity\Participant;
use App\Form\ProfilFormType;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'profil_')]

class ProfilController extends AbstractController
{

    #[Route('profil', name: 'afficher')]
    public function afficherProfil(ParticipantRepository $participantRepository): Response
    {
        $participant = $this->getUser();

        return $this->render('profil/profil.html.twig', ['participant' => $participant]);
    }

    #[Route('profil/modifier', name: 'modifier')]
    public function modifierProfile(ParticipantRepository $participantRepository,
                                    Request $request,
                                    EntityManagerInterface $entityManager,
                                    UserPasswordHasherInterface $passwordHasher): Response
    {
        $participant = $this->getUser();
        $profilForm = $this->createForm(ProfilFormType::class, $participant);
        $profilForm->handleRequest($request);

        if($profilForm->isSubmitted() && $profilForm->isValid()){
            $hashedPassword = $passwordHasher->hashPassword(
                $participant,
                $profilForm->get('motPasse')->getData()
            );
            $participant->setMotPasse($hashedPassword);

            $entityManager->persist($participant);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('profil/modifier.html.twig',
            ['profilForm' => $profilForm->createView()]);
    }
}

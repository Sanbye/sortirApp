<?php

namespace App\Controller;

use App\classes\Filtres;
use App\Form\SortiesFormType;
use App\Repository\SortieRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(SortieRepository      $sortieRepository,
                         Request $request): Response
    {
        $participant = $this->getUser();
        $filtres = new Filtres();

        //foreach($sorties->getParticipants() as $participants) {
        //    $nbParticipants = $participants.length;
        //}

        // PENSER A CREER UNE CLASSE FILTRE POUR RECUP
        $sortiesForm = $this->createForm(SortiesFormType::class);

        $sortiesForm->handleRequest($request);


        $filtres->setCampus($sortiesForm->get('campus')->getData());
        $filtres->setSearch($sortiesForm->get('search')->getData());

        // TRAITEMENT NULL DATE START
        $startDate =$sortiesForm->get('dateStart')->getData();
        if ($startDate == null) {
            $filtres->setDateStart(new \DateTime("-10years"));
        } else {
            $filtres->setDateStart($sortiesForm->get('dateStart')->getData());
        }

        // TRAITEMENT NULL DATE END
        $endDate =$sortiesForm->get('dateEnd')->getData();
        if ($endDate == null) {
            $filtres->setDateEnd(new \DateTime("+50years"));
        } else {
            $filtres->setDateEnd($sortiesForm->get('dateEnd')->getData());
        }

            $filtres->setChoiceOrganisateur($sortiesForm->get('choiceOrganisateur')->getData());
            $filtres->setChoiceInscrit($sortiesForm->get('choiceInscrit')->getData());
            $filtres->setChoiceNoInscrit($sortiesForm->get('choiceNoInscrit')->getData());
            $filtres->setChoiceEnd($sortiesForm->get('choiceEnd')->getData());

            if ($filtres == null) {
                $sorties = $sortieRepository->findAll();
            } else {
                $sorties = $sortieRepository->findAllWithQueries($filtres, $participant);
                //A REMPLACER PAR UNE REQUETE PERSONNALISEE POUR NOS FILTRES -
            }


            return $this->render('main/index.html.twig', [
                'participant' => $participant,
                'sorties' => $sorties,
                'sortiesForm' => $sortiesForm->createView(),
            ]);


    }
}

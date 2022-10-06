<?php

namespace App\Controller;

use DateTime;
use App\classes\Filtres;
use App\Form\SortiesFormType;
use App\Repository\SortieRepository;
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


                $sorties = $sortieRepository->findAll();



            return $this->render('main/index.html.twig', [
                'participant' => $participant,
                'sorties' => $sorties,
                'sortiesForm' => $sortiesForm->createView(),
            ]);


    }
}

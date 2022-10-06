<?php

namespace App\Controller;

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
    public function home(
        SortieRepository $sortieRepository,
        Request $request,
    ): Response {

        $participant = $this->getUser();
        $filtres = new Filtres();

        $sortiesForm = $this->createForm(SortiesFormType::class);
        $sortiesForm->handleRequest($request);

        if($sortiesForm->get('dateStart')->getData()==null) {
            $dateStart = new \DateTime("-10years");
        }else {
            $dateStart = $sortiesForm->get('dateStart')->getData();
        }
        if($sortiesForm->get('dateEnd')->getData()==null) {
            $dateEnd = new \DateTime("+50years");
        }else {
            $dateEnd = $sortiesForm->get('dateEnd')->getData();
        }

        $filtres->setCampus($sortiesForm->get('campus')->getData());
        $filtres->setSearch($sortiesForm->get('search')->getData());
        $filtres->setDateStart($dateStart);
        $filtres->setDateEnd($dateEnd);
        $filtres->setChoiceOrganisateur($sortiesForm->get('choiceOrganisateur')->getData());
        $filtres->setChoiceInscrit($sortiesForm->get('choiceInscrit')->getData());
        $filtres->setChoiceNoInscrit($sortiesForm->get('choiceNoInscrit')->getData());
        $filtres->setChoiceEnd($sortiesForm->get('choiceEnd')->getData());

        //$sorties = $sortieRepository->findAll();
        $sorties = $sortieRepository->findAllWithQueries($filtres, $participant);



            return $this->render('main/index.html.twig', [
                'participant' => $participant,
                'sorties' => $sorties,
                'sortiesForm' => $sortiesForm->createView(),
            ]);

    }
}

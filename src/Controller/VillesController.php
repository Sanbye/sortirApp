<?php

namespace App\Controller;

use App\Repository\CampusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/villes', name: 'villes_')]
class VillesController extends AbstractController
{
    #[Route('', name: 'list')]
    public function index(CampusRepository $campusRepository): Response
    {
        return $this->render('campus/index.html.twig', [
            'controller_name' => 'CampusController',
        ]);
    }
    #[Route('/create', name: 'create')]
    public function create(CampusRepository $campusRepository): Response
    {
        return $this->render('campus/index.html.twig', [
            'controller_name' => 'CampusController',
        ]);
    }

    #[Route('/update/{id}', name: 'update')]
    public function update(int $id, CampusRepository $campusRepository): Response
    {
        return $this->render('campus/index.html.twig', [
            'controller_name' => 'CampusController',
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(int $id, CampusRepository $campusRepository): Response
    {
        return $this->render('campus/index.html.twig', [
            'controller_name' => 'CampusController',
        ]);
    }
}

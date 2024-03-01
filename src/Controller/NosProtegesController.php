<?php

namespace App\Controller;

use App\Repository\PensionnairesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NosProtegesController extends AbstractController
{
    #[Route('/nos/proteges', name: 'app_nos_proteges')]
    public function index(PensionnairesRepository $pensionnairesRepository): Response
    {

        $pensionnaires = $pensionnairesRepository->findAll();

        return $this->render('nos_proteges/index.html.twig', [
            'controller_name' => 'NosProtegesController',
            'pensionnaires' => $pensionnaires, 
        ]);
    }
}

<?php

namespace App\Controller;

use App\Repository\PensionnairesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(PensionnairesRepository $pensionnairesRepository): Response
    {
        $pensionnaires = $pensionnairesRepository->findAll();

        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
            'pensionnaires' => $pensionnaires, 
        ]);
    }

}

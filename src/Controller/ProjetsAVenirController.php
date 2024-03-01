<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjetsAVenirController extends AbstractController
{
    #[Route('/projets/a/venir', name: 'app_projets_a_venir')]
    public function index(): Response
    {
        return $this->render('projets_a_venir/index.html.twig', [
            'controller_name' => 'ProjetsAVenirController',
        ]);
    }
}

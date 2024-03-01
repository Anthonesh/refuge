<?php

namespace App\Controller;

use App\Repository\PensionnairesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarouselController extends AbstractController
{
    #[Route('/components/carousel', name: 'app_carousel')]
    public function index( PensionnairesRepository $pensionnairesRepository): Response
    {

        $pensionnaires = $pensionnairesRepository->findIds();

        return $this->render('components/carousel.html.twig', [
            'controller_name' => 'CarouselController',
            'pensionnaires' => $pensionnaires, 
        ]);
    }
}

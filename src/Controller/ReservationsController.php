<?php

namespace App\Controller;

use App\Entity\Reservations;
use App\Entity\Jours;
use App\Entity\Heures;
use App\Repository\PensionnairesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ReservationBenevoleType; 
use App\Repository\ReservationsRepository;
use App\Repository\JoursRepository; 
use App\Repository\HeuresRepository; 
use Doctrine\ORM\EntityManagerInterface;

class ReservationsController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/reservation/create/{jourId}/{heureId}', name: 'app_reservations_create')]
    public function create(Request $request, int $jourId, int $heureId, JoursRepository $joursRepository, HeuresRepository $heuresRepository, ReservationsRepository $reservationsRepository, PensionnairesRepository $pensionnairesRepository): Response
    {
        $jour = $joursRepository->find($jourId);
        $heure = $heuresRepository->find($heureId);
        $pensionnaires = $pensionnairesRepository->findAll();

        $reservation = new Reservations();
        $reservation->setJour($jour);
        $reservation->setHeure($heure);

        $form = $this->createForm(ReservationBenevoleType::class, $reservation);

        // Traitez le formulaire lorsqu'il est soumis
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrez la réservation dans la base de données
            $this->entityManager->persist($reservation);
            $this->entityManager->flush();

            // Redirigez l'utilisateur vers une page de confirmation ou une autre page appropriée
            return $this->redirectToRoute('app_benevolat');
        }

        // Affichez le formulaire de réservation dans votre template
        return $this->render('reservations/reservations.html.twig', [
            'form' => $form->createView(),
            'jourId' => $jourId,
            'heureId' => $heureId,
            'pensionnaires' => $pensionnaires, 
        ]);
    }

    
}

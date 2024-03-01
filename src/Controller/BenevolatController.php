<?php

namespace App\Controller;

use App\Entity\Jours;
use App\Entity\Heures;
use App\Entity\Reservations;
use App\Form\ReservationBenevoleType;
use App\Repository\PensionnairesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class BenevolatController extends AbstractController
{
    #[Route('/benevolat', name: 'app_benevolat')]
    public function index(EntityManagerInterface $entityManager,PensionnairesRepository $pensionnairesRepository): Response
    {
        $jours = $entityManager->getRepository(Jours::class)->findAll();
        $plagesHoraires = $entityManager->getRepository(Heures::class)->findAll();
        $pensionnaires = $pensionnairesRepository->findAll();

        $reservations = [];
        foreach ($jours as $jour) {
            $reservations[$jour->getId()] = [];
            foreach ($plagesHoraires as $plageHoraire) {
                $reservations[$jour->getId()][$plageHoraire->getId()] = $entityManager
                    ->getRepository(Reservations::class)
                    ->findOneBy(['heure' => $plageHoraire]);
            }
        }

        return $this->render('benevolat/benevolat.html.twig', [
            'jours' => $jours,
            'plagesHoraires' => $plagesHoraires,
            'reservations' => $reservations,
            'controller_name' => 'BenevolatController',
            'pensionnaires' => $pensionnaires, 
        ]);
    }

    #[Route('/reservation/create/{jourId}/{heureId}', name: 'app_reservation_create')]
    public function createReservation(Request $request, int $jourId, int $heureId, PensionnairesRepository $pensionnairesRepository, ReservationBenevoleType $reservation ): Response
    {
        // Récupérez les entités Jours et Heures correspondant aux identifiants jourId et heureId
        $jour = $this->getDoctrine()->getRepository(Jours::class)->find($jourId);
        $heure = $this->getDoctrine()->getRepository(Heures::class)->find($heureId);
        $pensionnaires = $pensionnairesRepository->findAll();

        // Créez une nouvelle réservation et associez-la au jour et à l'heure appropriés
        $reservation = new Reservations();
        $reservation->setJour($jour);
        $reservation->setHeure($heure);

        // Créez un formulaire de réservation en utilisant le formulaire ReservationBenevoleType
        $form = $this->createForm(ReservationBenevoleType::class, $reservation);

        // Traitez le formulaire lorsqu'il est soumis
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrez la réservation dans la base de données
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reservation);
            $entityManager->flush();

            // Redirigez l'utilisateur vers une page de confirmation ou une autre page appropriée
            return $this->redirectToRoute('app_index');
        }

        // Affichez le formulaire de réservation dans votre template
        return $this->render('reservation/reservation.html.twig', [
            'form' => $form->createView(),
            'pensionnaires' => $pensionnaires, 
        ]);
    }
}

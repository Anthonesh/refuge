<?php

namespace App\Controller;

use App\Entity\Formulaires;
use App\Form\FormulairesType; // N'oubliez pas d'ajouter le use pour le formulaire
use App\Repository\CalendrierRepository;
use App\Repository\PensionnairesRepository;
use App\Service\ReservationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EvenementielController extends AbstractController
{
    #[Route('/evenementiel', name: 'app_evenementiel')]
    public function index(PensionnairesRepository $pensionnairesRepository,CalendrierRepository $calendrierRepo,
    ReservationService $reservationService): Response {
        
        $events = $calendrierRepo->findAll();

        $evts = [];

        foreach ($events as $event) {
        
            // Stockez les informations de l'événement avec les informations des formulaires
            $evts[] = [
                'id' => $event->getId(),
                'titre_calendrier' => $event->getTitreCalendrier(),
                'debut_calendrier' => $event->getDebutCalendrier()->format('Y-m-d H:i:s'),
                'fin_calendrier' => $event->getFinCalendrier()->format('Y-m-d H:i:s'),
                'description_calendrier' => $event->getDescriptionCalendrier(),
                'couleur_fond_calendrier' => $event->getCouleurFondCalendrier(),
                'couleur_bordure_calendrier' => $event->getCouleurBordureCalendrier(),
                'couleur_texte_calendrier' => $event->getCouleurTexteCalendrier(),
                'places_disponibles_calendrier' => $event->getPlacesDisponiblesCalendrier(),
            ];
        }

        $pensionnaires = $pensionnairesRepository->findAll();

        return $this->render('evenementiel/index.html.twig', [
            'controller_name' => 'EvenementielController',
            'events' => $evts,
            'pensionnaires' => $pensionnaires,
        ]);
    }

    #[Route('/evenementiel/reserver/{id}', name: 'app_evenementiel_reserver')]
    public function reserver(
        Request $request,
        PensionnairesRepository $pensionnairesRepository,
        CalendrierRepository $calendrierRepo,
        ReservationService $reservationService,
        $id
    ): Response {
        $calendrier = $calendrierRepo->find($id);
        $reservation = new Formulaires();
        $form = $this->createForm(FormulairesType::class, $reservation);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $reservationService->effectuerReservation($calendrier, $reservation);
                $this->addFlash('success', 'Réservation effectuée avec succès.');
            } catch (\Exception $e) {
                $this->addFlash('error', $e->getMessage());
            }
    
            return $this->redirectToRoute('app_evenementiel');
        }
    
        $pensionnaires = $pensionnairesRepository->findAll();
        // Ajout d'un return pour gérer les cas où le formulaire n'est pas soumis ou valide.
        // Adaptez cette partie selon votre logique d'affichage du formulaire ou toute autre page que vous souhaitez afficher
        return $this->render('calendrier/new.html.twig', [
            'form' => $form->createView(),
            'pensionnaires' => $pensionnaires,
        ]);
    }
}

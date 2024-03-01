<?php

namespace App\Controller;

use App\Entity\Formulaires;
use App\Form\Formulaires1Type;
use App\Repository\CalendrierRepository;
use App\Repository\FormulairesRepository;
use App\Repository\PensionnairesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/formulaires/evenementiel')]
class FormulairesEvenementielController extends AbstractController
{
    #[Route('/', name: 'app_formulaires_evenementiel_index', methods: ['GET'])]
    public function index(FormulairesRepository $formulairesRepository, PensionnairesRepository $pensionnairesRepository): Response
    {
        $pensionnaires = $pensionnairesRepository->findAll();

        return $this->render('formulaires_evenementiel/index.html.twig', [
            'formulaires' => $formulairesRepository->findAll(),
            'pensionnaires' => $pensionnaires,
        ]);
    }

    #[Route('/new', name: 'app_formulaires_evenementiel_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, CalendrierRepository $calendrierRepository,PensionnairesRepository $pensionnairesRepository,): Response
    {
        $formulaire = new Formulaires();
        // ... votre code pour pré-remplir le formulaire ou pour récupérer un formulaire existant ...
        $pensionnaires = $pensionnairesRepository->findAll();

    
        $form = $this->createForm(Formulaires1Type::class, $formulaire);
        $form->handleRequest($request);

        $eventId = $request->query->get('eventId');
        if ($eventId) {
            // Trouvez l'entité Calendrier correspondante
            $calendrier = $calendrierRepository->find($eventId);
    
            if ($calendrier) {
                // Associez le calendrier à l'entité Formulaire
                $formulaire->setCalendrier($calendrier);
            } else {
                // Gérez le cas où le calendrier n'est pas trouvé
                $this->addFlash('error', 'Calendrier non trouvé.');
                return $this->redirectToRoute('some_route'); // Redirigez vers une route appropriée
            }
    
        if ($form->isSubmitted() && $form->isValid()) {
            $nombreParticipants = $formulaire->getNombreParticipantsFormulaire();
            $calendrier = $formulaire->getCalendrier(); // Obtenez l'événement associé
            $placesDisponibles = $calendrier->getPlacesDisponiblesCalendrier();
    
            if ($placesDisponibles >= $nombreParticipants) {
                // Soustrayez le nombre de participants du nombre de places disponibles
                $calendrier->setPlacesDisponiblesCalendrier($placesDisponibles - $nombreParticipants);
    
                // Sauvegardez l'objet formulaire et l'objet calendrier
                $entityManager->persist($formulaire);
                $entityManager->persist($calendrier);
                $entityManager->flush();
    
                // Redirigez ou affichez un message de succès
                $this->addFlash('success', 'Votre réservation a été enregistrée avec succès.');
                return $this->redirectToRoute('app_evenementiel');
            } else {
                // Affichez un message d'erreur si le nombre de places disponibles est insuffisant
                $this->addFlash('error', 'Il n’y a pas assez de places disponibles pour cette réservation.');
            }
        }
    
        $pensionnaires = $pensionnairesRepository->findAll();

        return $this->render('formulaires_evenementiel/new.html.twig', [
            'formulaire' => $formulaire,
            'form' => $form,
            'pensionnaires' => $pensionnaires,
        ]);
    }
}

    #[Route('/{id}', name: 'app_formulaires_evenementiel_show', methods: ['GET'])]
    public function show(Formulaires $formulaire, PensionnairesRepository $pensionnairesRepository): Response
    {
        $pensionnaires = $pensionnairesRepository->findAll();

        return $this->render('formulaires_evenementiel/show.html.twig', [
            'formulaire' => $formulaire,
            'pensionnaires' => $pensionnaires,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_formulaires_evenementiel_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Formulaires $formulaire, EntityManagerInterface $entityManager, PensionnairesRepository $pensionnairesRepository): Response
    {
        $form = $this->createForm(Formulaires1Type::class, $formulaire);
        $form->handleRequest($request);
        $pensionnaires = $pensionnairesRepository->findAll();


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_formulaires_evenementiel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('formulaires_evenementiel/edit.html.twig', [
            'formulaire' => $formulaire,
            'form' => $form,
            'pensionnaires' => $pensionnaires,
        ]);
    }

    #[Route('/{id}', name: 'app_formulaires_evenementiel_delete', methods: ['POST'])]
    public function delete(Request $request, Formulaires $formulaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formulaire->getId(), $request->request->get('_token'))) {
            $entityManager->remove($formulaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_formulaires_evenementiel_index', [], Response::HTTP_SEE_OTHER);
    }
}

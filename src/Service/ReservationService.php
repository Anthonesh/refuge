<?php

namespace App\Service;

use App\Entity\Calendrier;
use App\Entity\Formulaires;
use Doctrine\ORM\EntityManagerInterface;

class ReservationService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function effectuerReservation(Calendrier $calendrier, Formulaires $reservation)
    {
        // Ajoutez la réservation au calendrier
        $calendrier->addFormulaire($reservation);
        
        // Calculez le nouveau nombre de places disponibles
        $placesRestantes = $calendrier->getPlacesDisponiblesCalendrier() - $reservation->getNombreParticipantsFormulaire();
        
        // Assurez-vous que le nombre de places restantes n'est pas négatif
        if ($placesRestantes < 0) {
            throw new \Exception("Il n'y a pas assez de places disponibles.");
        }
        
        // Mettez à jour le nombre de places disponibles
        $calendrier->setPlacesDisponiblesCalendrier($placesRestantes);
    
        // Persister les modifications dans la base de données
        $this->entityManager->persist($calendrier);
        $this->entityManager->flush();
    }
}
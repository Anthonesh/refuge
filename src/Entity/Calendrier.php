<?php

namespace App\Entity;

use App\Repository\CalendrierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CalendrierRepository::class)]
class Calendrier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'id_calendrier')]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $titre_calendrier = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $debut_calendrier = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fin_calendrier = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description_calendrier = null;

    #[ORM\Column(length: 7, nullable: true)]
    private ?string $couleur_fond_calendrier = null;

    #[ORM\Column(length: 7, nullable: true)]
    private ?string $couleur_bordure_calendrier = null;

    #[ORM\Column(length: 7, nullable: true)]
    private ?string $couleur_texte_calendrier = null;

    #[ORM\OneToMany(mappedBy: 'calendrier', targetEntity: Formulaires::class)]
    private Collection $formulaires;

    #[ORM\Column(nullable: true)]
    private ?int $places_disponibles_calendrier = null;

    #[ORM\Column(nullable: true)]
    private ?int $nombre_total_places_calendrier = null;

    public function __construct()
    {
        $this->formulaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreCalendrier(): ?string
    {
        return $this->titre_calendrier;
    }

    public function setTitreCalendrier(string $titre_calendrier): static
    {
        $this->titre_calendrier = $titre_calendrier;

        return $this;
    }

    public function getDebutCalendrier(): ?\DateTimeInterface
    {
        return $this->debut_calendrier;
    }

    public function setDebutCalendrier(\DateTimeInterface $debut_calendrier): static
    {
        $this->debut_calendrier = $debut_calendrier;

        return $this;
    }

    public function getFinCalendrier(): ?\DateTimeInterface
    {
        return $this->fin_calendrier;
    }

    public function setFinCalendrier(\DateTimeInterface $fin_calendrier): static
    {
        $this->fin_calendrier = $fin_calendrier;

        return $this;
    }

    public function getDescriptionCalendrier(): ?string
    {
        return $this->description_calendrier;
    }

    public function setDescriptionCalendrier(?string $description_calendrier): static
    {
        $this->description_calendrier = $description_calendrier;

        return $this;
    }

    public function getCouleurFondCalendrier(): ?string
    {
        return $this->couleur_fond_calendrier;
    }

    public function setCouleurFondCalendrier(?string $couleur_fond_calendrier): static
    {
        $this->couleur_fond_calendrier = $couleur_fond_calendrier;

        return $this;
    }

    public function getCouleurBordureCalendrier(): ?string
    {
        return $this->couleur_bordure_calendrier;
    }

    public function setCouleurBordureCalendrier(?string $couleur_bordure_calendrier): static
    {
        $this->couleur_bordure_calendrier = $couleur_bordure_calendrier;

        return $this;
    }

    public function getCouleurTexteCalendrier(): ?string
    {
        return $this->couleur_texte_calendrier;
    }

    public function setCouleurTexteCalendrier(?string $couleur_texte_calendrier): static
    {
        $this->couleur_texte_calendrier = $couleur_texte_calendrier;

        return $this;
    }

    /**
     * @return Collection<int, Formulaires>
     */
    public function getFormulaires(): Collection
    {
        return $this->formulaires;
    }

    public function addFormulaire(Formulaires $formulaire): self
    {
        if (!$this->formulaires->contains($formulaire)) {
            $this->formulaires->add($formulaire);
            $formulaire->setCalendrier($this);
            // Ajuster le nombre de places disponibles
            $this->adjustAvailablePlaces($formulaire->getNombreParticipantsFormulaire());
        }
    
        return $this;
    }
    
    public function removeFormulaire(Formulaires $formulaire): self
    {
        if ($this->formulaires->removeElement($formulaire)) {
            // set the owning side to null (unless already changed)
            if ($formulaire->getCalendrier() === $this) {
                $formulaire->setCalendrier(null);
            }
            // Ajuster le nombre de places disponibles
            $this->adjustAvailablePlaces(-$formulaire->getNombreParticipantsFormulaire());
        }
    
        return $this;
    }
    
    private function adjustAvailablePlaces(int $participantCountChange): void
    {
        $this->setPlacesDisponiblesCalendrier($this->getPlacesDisponiblesCalendrier() - $participantCountChange);
    }

    public function getPlacesDisponiblesCalendrier(): ?int
    {
        return $this->places_disponibles_calendrier;
    }

    public function setPlacesDisponiblesCalendrier(?int $placesDisponiblesCalendrier): self
    {
        if ($placesDisponiblesCalendrier < 0) {
            throw new \Exception("Le nombre de places disponibles ne peut pas être négatif.");
        }
        $this->places_disponibles_calendrier = $placesDisponiblesCalendrier;

        return $this;
    }


    public function getNombreTotalPlacesCalendrier(): ?int
    {
        return $this->nombre_total_places_calendrier;
    }

    public function setNombreTotalPlacesCalendrier(int $nombre_total_places_calendrier): static
    {
        $this->nombre_total_places_calendrier = $nombre_total_places_calendrier;

        return $this;
    }
    public function updateReservationDetails() {
        $nombreParticipants = 0;
        foreach ($this->getFormulaires() as $formulaire) {
            $nombreParticipants += $formulaire->getNombreParticipantsFormulaire();
        }
    
        // Mettez à jour le nombre de places disponibles
        $this->setPlacesDisponiblesCalendrier($this->getPlacesDisponiblesCalendrier() - $nombreParticipants);
    }

}

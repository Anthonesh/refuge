<?php

namespace App\Entity;

use App\Repository\JoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JoursRepository::class)]
class Jours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $jour_semaine = null;

    #[ORM\OneToMany(mappedBy: 'jour', targetEntity: Heures::class)]
    private Collection $heures;

    #[ORM\OneToMany(mappedBy: 'jour', targetEntity: Reservations::class)]
    private Collection $reservations;

    public function __construct()
    {
        $this->heures = new ArrayCollection();
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJourSemaine(): ?string
    {
        return $this->jour_semaine;
    }

    public function setJourSemaine(?string $jour_semaine): static
    {
        $this->jour_semaine = $jour_semaine;

        return $this;
    }

    /**
     * @return Collection<int, Heures>
     */
    public function getHeures(): Collection
    {
        return $this->heures;
    }

    public function addHeure(Heures $heure): static
    {
        if (!$this->heures->contains($heure)) {
            $this->heures->add($heure);
            $heure->setJour($this);
        }

        return $this;
    }

    public function removeHeure(Heures $heure): static
    {
        if ($this->heures->removeElement($heure)) {
            // set the owning side to null (unless already changed)
            if ($heure->getJour() === $this) {
                $heure->setJour(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reservations>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservations $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setJour($this);
        }

        return $this;
    }

    public function removeReservation(Reservations $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getJour() === $this) {
                $reservation->setJour(null);
            }
        }

        return $this;
    }
}

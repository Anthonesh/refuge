<?php

namespace App\Entity;

use App\Repository\FormulairesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormulairesRepository::class)]
class Formulaires
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'id_formulaire', type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $nom_formulaire = null;

    #[ORM\Column(length: 30)]
    private ?string $prenom_formulaire = null;

    #[ORM\Column(length: 15)]
    private ?string $telephone_formulaire = null;

    #[ORM\Column(length: 100)]
    private ?string $email_formulaire = null;

    #[ORM\Column]
    private ?int $numero_rue_formulaire = null;

    #[ORM\Column(length: 255)]
    private ?string $rue_formulaire = null;

    #[ORM\Column(length: 10)]
    private ?string $code_postal_formulaire = null;

    #[ORM\Column(length: 30)]
    private ?string $ville_formulaire = null;

    #[ORM\Column(length: 30)]
    private ?string $pays_formulaire = null;

    #[ORM\ManyToOne(targetEntity: Calendrier::class, inversedBy: 'formulaires')]
    #[ORM\JoinColumn(name: 'calendrier_id', referencedColumnName: 'id_calendrier')]
    private ?Calendrier $calendrier = null;

    #[ORM\Column(nullable: true)]
    private ?int $nombre_participants_formulaire = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom_facturation_formulaire = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFormulaire(): ?string
    {
        return $this->nom_formulaire;
    }

    public function setNomFormulaire(string $nom_formulaire): static
    {
        $this->nom_formulaire = $nom_formulaire;

        return $this;
    }

    public function getPrenomFormulaire(): ?string
    {
        return $this->prenom_formulaire;
    }

    public function setPrenomFormulaire(string $prenom_formulaire): static
    {
        $this->prenom_formulaire = $prenom_formulaire;

        return $this;
    }

    public function getTelephoneFormulaire(): ?string
    {
        return $this->telephone_formulaire;
    }

    public function setTelephoneFormulaire(string $telephone_formulaire): static
    {
        $this->telephone_formulaire = $telephone_formulaire;

        return $this;
    }

    public function getEmailFormulaire(): ?string
    {
        return $this->email_formulaire;
    }

    public function setEmailFormulaire(string $email_formulaire): static
    {
        $this->email_formulaire = $email_formulaire;

        return $this;
    }

    public function getNumeroRueFormulaire(): ?int
    {
        return $this->numero_rue_formulaire;
    }

    public function setNumeroRueFormulaire(int $numero_rue_formulaire): static
    {
        $this->numero_rue_formulaire = $numero_rue_formulaire;

        return $this;
    }

    public function getRueFormulaire(): ?string
    {
        return $this->rue_formulaire;
    }

    public function setRueFormulaire(string $rue_formulaire): static
    {
        $this->rue_formulaire = $rue_formulaire;

        return $this;
    }

    public function getCodePostalFormulaire(): ?string
    {
        return $this->code_postal_formulaire;
    }

    public function setCodePostalFormulaire(string $code_postal_formulaire): static
    {
        $this->code_postal_formulaire = $code_postal_formulaire;

        return $this;
    }

    public function getVilleFormulaire(): ?string
    {
        return $this->ville_formulaire;
    }

    public function setVilleFormulaire(string $ville_formulaire): static
    {
        $this->ville_formulaire = $ville_formulaire;

        return $this;
    }

    public function getPaysFormulaire(): ?string
    {
        return $this->pays_formulaire;
    }

    public function setPaysFormulaire(string $pays_formulaire): static
    {
        $this->pays_formulaire = $pays_formulaire;

        return $this;
    }

    public function getCalendrier(): ?Calendrier
    {
        return $this->calendrier;
    }

    public function setCalendrier(?Calendrier $calendrier): static
    {
        $this->calendrier = $calendrier;

        return $this;
    }

    public function getNombreParticipantsFormulaire(): ?int
    {
        return $this->nombre_participants_formulaire;
    }

    public function setNombreParticipantsFormulaire(int $nombre_participants_formulaire): static
    {
        $this->nombre_participants_formulaire = $nombre_participants_formulaire;

        return $this;
    }

    public function getNomFacturationFormulaire(): ?string
    {
        return $this->nom_facturation_formulaire;
    }

    public function setNomFacturationFormulaire(?string $nom_facturation_formulaire): static
    {
        $this->nom_facturation_formulaire = $nom_facturation_formulaire;

        return $this;
    }

}

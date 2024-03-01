<?php

namespace App\Entity;

use App\Repository\DonsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DonsRepository::class)]
class Dons
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'id_don')]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Le nom est requis')]
    private ?string $nom_don = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Le prénom est requis')]
    private ?string $prenom_don = null;

    #[ORM\Column(length: 15)]
    #[Assert\NotBlank(message: 'Le numéro de téléphone est requis')]
    private ?string $telephone_don = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "L'adresse e-mail est requise")]
    private ?string $email_don = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Le numéro de la rue est requis')]
    private ?int $numero_rue_don = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le nom de la rue est requis')]
    private ?string $libelle_rue_don = null;

    #[ORM\Column(length: 10)]
    #[Assert\NotBlank(message: 'Le code postal est requis')]
    private ?string $code_postal_don = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message: 'La ville est requise')]
    private ?string $ville_don = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message: 'Le pays est requis')]
    private ?string $pays_don = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Le montant est requis')]
    private ?int $montant_don = null;

    #[ORM\Column(length: 3)]
    private ?string $monnaie_don = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $stripe_transaction_id_don = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $paiement_statut_don = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDon(): ?string
    {
        return $this->nom_don;
    }

    public function setNomDon(string $nom_don): static
    {
        $this->nom_don = $nom_don;

        return $this;
    }

    public function getPrenomDon(): ?string
    {
        return $this->prenom_don;
    }

    public function setPrenomDon(string $prenom_don): static
    {
        $this->prenom_don = $prenom_don;

        return $this;
    }

    public function getTelephoneDon(): ?string
    {
        return $this->telephone_don;
    }

    public function setTelephoneDon(string $telephone_don): static
    {
        $this->telephone_don = $telephone_don;

        return $this;
    }

    public function getEmailDon(): ?string
    {
        return $this->email_don;
    }

    public function setEmailDon(string $email_don): static
    {
        $this->email_don = $email_don;

        return $this;
    }

    public function getNumeroRueDon(): ?int
    {
        return $this->numero_rue_don;
    }

    public function setNumeroRueDon(int $numero_rue_don): static
    {
        $this->numero_rue_don = $numero_rue_don;

        return $this;
    }

    public function getLibelleRueDon(): ?string
    {
        return $this->libelle_rue_don;
    }

    public function setLibelleRueDon(string $libelle_rue_don): static
    {
        $this->libelle_rue_don = $libelle_rue_don;

        return $this;
    }

    public function getCodePostalDon(): ?string
    {
        return $this->code_postal_don;
    }

    public function setCodePostalDon(string $code_postal_don): static
    {
        $this->code_postal_don = $code_postal_don;

        return $this;
    }

    public function getVilleDon(): ?string
    {
        return $this->ville_don;
    }

    public function setVilleDon(string $ville_don): static
    {
        $this->ville_don = $ville_don;

        return $this;
    }

    public function getPaysDon(): ?string
    {
        return $this->pays_don;
    }

    public function setPaysDon(string $pays_don): static
    {
        $this->pays_don = $pays_don;

        return $this;
    }

    public function getMontantDon(): ?int
    {
        return $this->montant_don;
    }

    public function setMontantDon(int $montant_don): static
    {
        $this->montant_don = $montant_don;

        return $this;
    }

    public function getMonnaieDon(): ?string
    {
        return $this->monnaie_don;
    }

    public function setMonnaieDon(string $monnaie_don): static
    {
     
        $this->monnaie_don = $monnaie_don;

        return $this;
    }

    public function getStripeTransactionIdDon(): ?string
    {
        return $this->stripe_transaction_id_don;
    }

    public function setStripeTransactionIdDon(?string $stripe_transaction_id_don): static
    {
        $this->stripe_transaction_id_don = $stripe_transaction_id_don;

        return $this;
    }

    public function getPaiementStatutDon(): ?string
    {
        return $this->paiement_statut_don;
    }

    public function setPaiementStatutDon(?string $paiement_statut_don): static
    {
        $this->paiement_statut_don = $paiement_statut_don;

        return $this;
    }

   

}

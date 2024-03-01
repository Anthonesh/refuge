<?php

namespace App\Entity;

use App\Repository\InformationsPensionnairesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InformationsPensionnairesRepository::class)]
class InformationsPensionnaires
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'id_information_pensionnaire')]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $nourriture_information_pensionnaire = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $soin_information_pensionnaire = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $carnet_de_sante_information_pensionnaire = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $histoire_information_pensionnaire = null;

    #[ORM\OneToOne(inversedBy: 'informationPensionnaire')]
    #[ORM\JoinColumn(name: 'pensionnaire_id', referencedColumnName: 'id_pensionnaire')]
    private ?Pensionnaires $pensionnaire = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNourritureInformationPensionnaire(): ?string
    {
        return $this->nourriture_information_pensionnaire;
    }

    public function setNourritureInformationPensionnaire(?string $nourriture_information_pensionnaire): static
    {
        $this->nourriture_information_pensionnaire = $nourriture_information_pensionnaire;

        return $this;
    }

    public function getSoinInformationPensionnaire(): ?string
    {
        return $this->soin_information_pensionnaire;
    }

    public function setSoinInformationPensionnaire(?string $soin_information_pensionnaire): static
    {
        $this->soin_information_pensionnaire = $soin_information_pensionnaire;

        return $this;
    }

    public function getCarnetDeSanteInformationPensionnaire(): ?string
    {
        return $this->carnet_de_sante_information_pensionnaire;
    }

    public function setCarnetDeSanteInformationPensionnaire(?string $carnet_de_sante_information_pensionnaire): static
    {
        $this->carnet_de_sante_information_pensionnaire = $carnet_de_sante_information_pensionnaire;

        return $this;
    }

    public function getHistoireInformationPensionnaire(): ?string
    {
        return $this->histoire_information_pensionnaire;
    }

    public function setHistoireInformationPensionnaire(?string $histoire_information_pensionnaire): static
    {
        $this->histoire_information_pensionnaire = $histoire_information_pensionnaire;

        return $this;
    }

    public function getPensionnaire(): ?Pensionnaires
    {
        return $this->pensionnaire;
    }

    public function setPensionnaire(?Pensionnaires $pensionnaire): static
    {
        $this->pensionnaire = $pensionnaire;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\VideosRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VideosRepository::class)]
class Videos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $titre_video = null;

    #[ORM\Column(length: 255)]
    private ?string $lien_video = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreVideo(): ?string
    {
        return $this->titre_video;
    }

    public function setTitreVideo(?string $titre_video): static
    {
        $this->titre_video = $titre_video;

        return $this;
    }

    public function getLienVideo(): ?string
    {
        return $this->lien_video;
    }

    public function setLienVideo(string $lien_video): static
    {
        $this->lien_video = $lien_video;

        return $this;
    }
}

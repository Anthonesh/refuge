<?php

namespace App\Entity;

use App\Repository\UtilisateursRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateursRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Utilisateurs implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'id_utilisateurs')]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true, name:'email_utilisateurs')]
    private ?string $email = null;

    #[ORM\Column(name:'role_utilisateur')]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column(name:'mot_de_passe_utilisateur')]
    private ?string $password = null;

    #[ORM\Column(length: 25)]
    private ?string $nom_utilisateur = null;

    #[ORM\Column(length: 25)]
    private ?string $prenom_utilisateur = null;

    #[ORM\Column(length: 15)]
    private ?string $numero_telephone_utilisateur = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNomUtilisateur(): ?string
    {
        return $this->nom_utilisateur;
    }

    public function setNomUtilisateur(string $nom_utilisateur): static
    {
        $this->nom_utilisateur = $nom_utilisateur;

        return $this;
    }

    public function getPrenomUtilisateur(): ?string
    {
        return $this->prenom_utilisateur;
    }

    public function setPrenomUtilisateur(string $prenom_utilisateur): static
    {
        $this->prenom_utilisateur = $prenom_utilisateur;

        return $this;
    }

    public function getNumeroTelephoneUtilisateur(): ?string
    {
        return $this->numero_telephone_utilisateur;
    }

    public function setNumeroTelephoneUtilisateur(string $numero_telephone_utilisateur): static
    {
        $this->numero_telephone_utilisateur = $numero_telephone_utilisateur;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}

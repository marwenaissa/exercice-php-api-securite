<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SocieteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SocieteRepository::class)]
#[ApiResource]
class Societe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $numeroSIRET = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    /**
     * @var Collection<int, Projet>
     */
    #[ORM\OneToMany(targetEntity: Projet::class, mappedBy: 'societe')]
    private Collection $projets;

    /**
     * @var Collection<int, UserSociete>
     */
    #[ORM\OneToMany(targetEntity: UserSociete::class, mappedBy: 'idSociete')]
    private Collection $userSocietes;

    public function __construct()
    {
        $this->projets = new ArrayCollection();
        $this->userSocietes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getNumeroSIRET(): ?string
    {
        return $this->numeroSIRET;
    }

    public function setNumeroSIRET(string $numeroSIRET): static
    {
        $this->numeroSIRET = $numeroSIRET;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return Collection<int, Projet>
     */
    public function getProjets(): Collection
    {
        return $this->projets;
    }

    public function addProjet(Projet $projet): static
    {
        if (!$this->projets->contains($projet)) {
            $this->projets->add($projet);
            $projet->setSociete($this);
        }

        return $this;
    }

    public function removeProjet(Projet $projet): static
    {
        if ($this->projets->removeElement($projet)) {
            // set the owning side to null (unless already changed)
            if ($projet->getSociete() === $this) {
                $projet->setSociete(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserSociete>
     */
    public function getUserSocietes(): Collection
    {
        return $this->userSocietes;
    }

    public function addUserSociete(UserSociete $userSociete): static
    {
        if (!$this->userSocietes->contains($userSociete)) {
            $this->userSocietes->add($userSociete);
            $userSociete->setIdSociete($this);
        }

        return $this;
    }

    public function removeUserSociete(UserSociete $userSociete): static
    {
        if ($this->userSocietes->removeElement($userSociete)) {
            // set the owning side to null (unless already changed)
            if ($userSociete->getIdSociete() === $this) {
                $userSociete->setIdSociete(null);
            }
        }

        return $this;
    }
}

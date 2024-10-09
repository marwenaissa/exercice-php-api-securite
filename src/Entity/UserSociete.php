<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserSocieteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserSocieteRepository::class)]
#[ApiResource]
class UserSociete
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userSocietes')]
    private ?User $idUser = null;

    #[ORM\ManyToOne(inversedBy: 'userSocietes')]
    private ?Societe $idSociete = null;

    #[ORM\ManyToOne]
    private ?Role $idRole = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): static
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getIdSociete(): ?Societe
    {
        return $this->idSociete;
    }

    public function setIdSociete(?Societe $idSociete): static
    {
        $this->idSociete = $idSociete;

        return $this;
    }

    public function getIdRole(): ?Role
    {
        return $this->idRole;
    }

    public function setIdRole(?Role $idRole): static
    {
        $this->idRole = $idRole;

        return $this;
    }
}

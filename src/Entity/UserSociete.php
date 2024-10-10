<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserSocieteRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\OpenApi\Model\Operation;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserSocieteRepository::class)]

#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/user_societes/societes/{idUser}/{idSociete}',
            openapi: new Operation(
                summary: 'Récupérer les projets associés à un utilisateur et une société',
            ),
            normalizationContext: ['groups' => ['user:projet:read']],
        )
    ],
    normalizationContext: ['groups' => [ 'user:societe:read']],
)]
class UserSociete
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:societe:read', 'user:projet:read'])]
    private ?int $id = null;

    
    #[ORM\ManyToOne(inversedBy: 'userSocietes')]
    #[Groups(['user:societe:read', 'user:projet:read'])]
    private ?User $idUser = null;

    #[ORM\ManyToOne(inversedBy: 'userSocietes')]
    #[Groups(['user:societe:read', 'user:projet:read'])]
    private ?Societe $idSociete = null;

    #[ORM\ManyToOne]
    #[Groups(['user:societe:read', 'user:projet:read'])]
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

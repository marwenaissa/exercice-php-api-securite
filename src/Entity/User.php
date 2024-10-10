<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\OpenApi\Model\Operation;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]

#[ApiResource(
    shortName: 'Utilisateurs',
    operations: [
    new Get(
        uriTemplate: '/users/{id}',
        openapi: new Operation(
            summary: 'Récupérer un utilisateur',
        ),
        normalizationContext: ['groups' => ['user:societe:read']],
    ),
    new Get(
        uriTemplate: '/users/projets/{id}',
        openapi: new Operation(
            summary: 'Récupérer les projets associés à un utilisateur',
        ),
        normalizationContext: ['groups' => ['user:projet:read']],
    ),
    new Post(
    uriTemplate: '/users',
    name:"create_user",
    openapi: new Operation(
    summary: 'Ajouter un utilisateur',
    )
    )],

    normalizationContext: ['groups' => ['user:societe:read' , 'user:projet:read' ]],
    denormalizationContext: ['groups' => ['user:societe:write']],
    forceEager: false,
)]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:societe:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Groups(['user:societe:read', 'user:societe:write'])]
    #[Assert\NotBlank(message:"L'email est obligatoire")]
    #[Assert\Email(message:"L'email est invalide")]
    private ?string $email = null;
    

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];
    
    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups(['user:societe:read', 'user:projet:read' , 'user:societe:write'])]
    private ?string $password = null;

    /**
     * @var Collection<int, Projet>
     */
    #[ORM\ManyToMany(targetEntity: Projet::class, mappedBy: 'users')]
    private Collection $projets;

    /**
     * @var Collection<int, UserSociete>
     */
    #[ORM\OneToMany(targetEntity: UserSociete::class, mappedBy: 'idUser')]
    #[Groups(['user:societe:read' , 'user:projet:read'])]
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
        return (string)$this->email;
    }

    /**
     * @return list<string>
     * @see UserInterface
     *
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
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
            $projet->addUser($this);
        }

        return $this;
    }

    public function removeProjet(Projet $projet): static
    {
        if ($this->projets->removeElement($projet)) {
            $projet->removeUser($this);
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
            $userSociete->setIdUser($this);
        }

        return $this;
    }

    public function removeUserSociete(UserSociete $userSociete): static
    {
        if ($this->userSocietes->removeElement($userSociete)) {
            // set the owning side to null (unless aluser:societe:ready changed)
            if ($userSociete->getIdUser() === $this) {
                $userSociete->setIdUser(null);
            }
        }

        return $this;
    }
}

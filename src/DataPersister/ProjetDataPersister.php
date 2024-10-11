<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Projet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ProjetDataPersister implements DataPersisterInterface
{
    private EntityManagerInterface $entityManager;
    private Security $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    public function supports($data): bool
    {
        return $data instanceof Projet;
    }

    public function persist($data)
    {
        // Check user role for creating or updating a project
        $user = $this->security->getUser();
        if ($user === null || !in_array($user->getIdRole(), [1, 2], true)) {
            throw new AccessDeniedHttpException('You do not have permission to create or update a project.');
        }

        // Automatically set the creation date if it's a new project
        if (null === $data->getDateCreation()) {
            $data->setDateCreation(new \DateTimeImmutable());
        }

        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    public function remove($data)
    {
        // Check user role for deleting a project
        $user = $this->security->getUser();
        if ($user === null || !in_array($user->getIdRole(), [1, 2], true)) {
            throw new AccessDeniedHttpException('You do not have permission to delete this project.');
        }

        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}

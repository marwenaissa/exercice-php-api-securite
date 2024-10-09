<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Factory\UserFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface; // Import EntityManagerInterface


class UserController extends AbstractController
{
    public function __construct(
        private readonly UserFactory $userFactory,
        private readonly UserPasswordHasherInterface $passwordHasher, // Injecting the password hasher,
        private readonly EntityManagerInterface $entityManager // Injecting the Entity Manager

    ) {
    }
    
    #[Route('/api/users', methods: ['POST'], name: "create_user")]
    public function createUser(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
    
        if (!isset($data['email']) || !isset($data['password'])) {
            return $this->json(['error' => 'Email and password are required'], Response::HTTP_BAD_REQUEST);
        }
    
        // Hash the password
        $hashedPassword = $this->passwordHasher->hashPassword(new User(), $data['password']);
    
        // Create the user using the factory methods
        $user = $this->userFactory
            ->createOne([
                'email' => $data['email'],
                'password' => $hashedPassword,
            ]);
    
        // Persist the user to the database
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    
        return $this->json($user, Response::HTTP_CREATED, [], ['groups' => ['read']]);
    }
    

}

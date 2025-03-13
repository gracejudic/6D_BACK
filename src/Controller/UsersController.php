<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

final class UsersController extends AbstractController
{
    #[Route('/users', name: 'app_users')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UsersController.php',
        ]);
    }

    #[Route('/users/add-user', name: 'add_user')]
    public function addUser(EntityManagerInterface $entityManager): Response
    {
        $user = new Users();

        $user->setMail('bonjour@mail.com');
        $user->setFirstname('Toto');
        $user->setLastname('Titi');
        $user->setIsAdmin(false);
        $user->setUsername('Totodu93');
        $user->setPassword('kill *****!');

        $entityManager->persist($user);
        
        $entityManager->flush();

        return new Response('Saved new user with id '.$user->getId());
    }
}

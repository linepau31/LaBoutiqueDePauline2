<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    #[Route('/inscription', name: 'register')]
    public function index(Request $request, UserPasswordHasherInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();

            $password = $encoder->hashPassword($user, $user->getPassword()); # mdp crypter
            $user->setPassword($password);

            $this->entityManager->persist($user);
            $this->entityManager->flush(); # éxecute la persistance, data (l'objet figé) = enregistre bdd
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView() # création du form
        ]);
    }
}

<?php

namespace App\Controller;

use App\Classe\Mail;
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
        $notification = null;

        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();

            $search_email = $this->entityManager->getRepository(User::class)->findOneByEmail($user->getEmail());

            if (!$search_email) {
                $password = $encoder->hashPassword($user, $user->getPassword()); // mdp crypter
                $user->setPassword($password);

                $this->entityManager->persist($user);
                $this->entityManager->flush(); // éxecute la persistance, data (l'objet figé) = enregistre bdd

                $mail = new Mail();
                $content = "Bonjour".$user->getFirstname()."<br/>Bienvenue sur la boutique dédiée a 100% Made in France.<br/><br/>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.";
                $mail->send($user->getEmail(), $user->getFirstname(), 'Bienvenue sur La Boutique De Pauline', $content);

                $notification = "Votre inscription s'est correctement déroulée. Vous pouvez dès à présent vous connecter à votre compte.";
            }
            else {
                $notification = "L'email que vous avez renseigné existe déjà.";
            }
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView(), // création du form
            'notification' => $notification
        ]);
    }
}

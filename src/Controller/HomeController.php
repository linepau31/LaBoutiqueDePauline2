<?php

namespace App\Controller;

use App\Classe\Mail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
      /* $mail = new Mail();
        $mail->send('pauline.marot2@outlook.fr', 'Pauline Marot', 'Mon premier mail', "Bonjour Pauline, Comment vas tu ?");*/

        return $this->render('home/index.html.twig');
    }
}

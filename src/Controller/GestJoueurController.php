<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GestJoueurController extends AbstractController
{
    #[Route('/gest/joueur', name: 'app_gest_joueur')]
    public function index(): Response
    {
        return $this->render('pages/gest_joueur/index.html.twig', [
            'controller_name' => 'GestJoueurController',
        ]);
    }
}

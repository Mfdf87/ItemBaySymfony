<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GestJoueurController extends AbstractController
{
    #[Route('/gest/joueur/{id}/{nom}/{prenom}/{email}', name: 'app_gest_joueur')]
    public function index($id, $nom, $prenom, $email): Response
    {
        $compte = [
            'id' => $id,
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            // ...
        ];

        return $this->render('pages/gest_joueur/index.html.twig', [
            'controller_name' => 'GestJoueurController',
            'compte' => $compte,
        ]);
    }
}

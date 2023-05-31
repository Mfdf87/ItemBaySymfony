<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'profil')]
    public function index(): Response
    {
        // On vérifie que l'utilisateur est connecté
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('pages/profil/index.html.twig', [
            'controller_name' => 'ProfilController',
        ]);
    }
}

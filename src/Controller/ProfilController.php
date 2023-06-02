<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'profil', methods: ['GET', 'POST'])]
    public function index(\App\Repository\UserRepository $userRepository): Response
    {        
        // On vérifie que l'utilisateur est connecté
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // On récupère l'id de l'user en post si il existe
        $id = $_POST['id'] ?? null;

        if ($id != null && $this->isGranted('ROLE_ADMIN')) {
            $user = $userRepository->find($id);

            return $this->render('pages/profil/index.html.twig', [
                'controller_name' => 'ProfilController',
                'user' => $user
            ]);
        }
        else if ($id != null && !$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_connexion');
        }
        else {
            $user = $this->getUser();
            return $this->render('pages/profil/index.html.twig', [
                'controller_name' => 'ProfilController',
                'user' => $user
            ]);
        }
    }
}

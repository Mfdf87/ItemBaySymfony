<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GestCmptController extends AbstractController
{
    #[Route('/gest/cmpt', name: 'app_gest_cmpt', methods: ['GET'])]
    public function index(UserRepository $repository): Response
    {
        // On bloque la page pour les personnes qui ne sont pas admin
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        return $this->render('pages/gest_cmpt/index.html.twig', [
            'controller_name' => 'GestCmptController',
            'comptes' => $repository->findAll()
        ]);
    }
}

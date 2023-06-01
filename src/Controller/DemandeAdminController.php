<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemandeAdminController extends AbstractController
{
    #[Route('/demande/admin', name: 'app_demande_admin')]
    public function index(): Response
    {
        return $this->render('demande_admin/index.html.twig', [
            'controller_name' => 'DemandeAdminController',
        ]);
    }
}

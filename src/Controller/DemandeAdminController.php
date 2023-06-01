<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemandeAdminController extends AbstractController
{
    #[Route('/demande/admin', name: 'app_demande_admin')]
    public function index(Request $request): Response
    {
        return $this->render('pages/demande_admin/index.html.twig', [
            'controller_name' => 'DemandeAdminController',
            'id' => $request->query->get('id'),
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SupportAdminController extends AbstractController
{
    #[Route('/support/admin', name: 'support_admin')]
    public function index(): Response
    {
        return $this->render('pages/support_admin/index.html.twig', [
            'controller_name' => 'SupportAdminController',
        ]);
    }
}

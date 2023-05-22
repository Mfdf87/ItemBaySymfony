<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GestCmptController extends AbstractController
{
    #[Route('/gest/cmpt', name: 'app_gest_cmpt')]
    public function index(): Response
    {
        return $this->render('pages/gest_cmpt/index.html.twig', [
            'controller_name' => 'GestCmptController',
        ]);
    }
}

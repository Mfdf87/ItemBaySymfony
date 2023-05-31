<?php

namespace App\Controller;

use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GestBoutiqueController extends AbstractController
{
    #[Route('/gest/boutique', name: 'app_gest_boutique',  methods: ['GET'])]
    public function index(ItemRepository $repository): Response
    {
        // On bloque la page pour les personnes qui ne sont pas admin
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('pages/gest_boutique/index.html.twig', [
            'controller_name' => 'GestBoutiqueController',
            'items' => $repository->findAll()
        ]);
    }
}

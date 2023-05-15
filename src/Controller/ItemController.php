<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ItemController extends AbstractController
{
    #[Route('/item/{id}/{nom}/{description}', name: 'item')]
    public function index($id, $nom, $description): Response
    {
        $item = [
            'id' => $id,
            'nom' => $nom,
            'description' => $description,
            // ...
        ];


        return $this->render('pages/item/index.html.twig', [
            'controller_name' => 'ItemController',
            'item' => $item,
        ]);
    }
}

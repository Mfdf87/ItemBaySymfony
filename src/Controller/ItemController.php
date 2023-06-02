<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ItemController extends AbstractController
{
    #[Route('/item', name: 'item', methods: ['POST'])]
    public function index(\App\Repository\ItemRepository $itemRepository): Response
    {
        $id = $_POST['id'];
        $action = $_POST['action'];
        $item = $itemRepository->find($id);
        if ($action == "see"){
            return $this->render('pages/item/index.html.twig', [
                'item' => $item,
            ]);
        }
        if ($action == "buy"){
            return $this->render('pages/item/index.html.twig', [
                'item' => $item,
                'buy' => 'true',
            ]);
        }
    }
}

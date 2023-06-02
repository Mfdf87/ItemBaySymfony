<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ItemController extends AbstractController
{
    #[Route('/item', name: 'item', methods: ['POST'])]
    public function index(\App\Repository\ItemRepository $itemRepository, Request $request): Response
    {
        $session = $request->getSession();
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
        if ($action == "update"){
            return $this->render('pages/item/index.html.twig', [
                'item' => $item,
                'update' => 'true',
            ]);
        }
        if ($action == "delete"){
            return $this->render('pages/item/index.html.twig', [
                'item' => $item,
                'delete' => 'true',
            ]);
        }
        if ($action == "addToCart"){
            // On va chercher le panier dans la session
            $cart = $session->get('cart');
            // Si le panier n'existe pas, on le crée
            if (!$cart) {
                $cart = [];
            }
            // On ajoute l'item au panier si il n'y est pas déjà
            if (!in_array($item, $cart)) {
                $cart[] = $item;
            }
            // On enregistre le panier dans la session
            $session->set('cart', $cart);

            // On redirige vers la page d'accueil
            return $this->redirectToRoute('home.index');
        }
    }
}

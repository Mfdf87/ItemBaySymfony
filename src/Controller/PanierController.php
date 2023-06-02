<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier', methods:['POST', 'GET'])]
    public function index(Request $request): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        if ($request->isMethod('POST') && $request->request->get('action') == 'delete') {
            $session = $request->getSession();
            $cart = $session->get('cart');
            $id = $request->request->get('id');
            $cart = array_filter($cart, function ($item) use ($id) {
                return $item->getId() != $id;
            });
            $session->set('cart', $cart);
        }
        $items = $request->getSession()->get('cart');
        if (!$items || $request->request->get('from') == 'home') {
            return $this->redirectToRoute('home.index');
        }
        return $this->render('pages/panier/index.html.twig', [
            'controller_name' => 'PanierController',
            'items' => $items,
        ]);
    }
}

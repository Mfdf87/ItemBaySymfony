<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Item;
use App\Entity\User;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier', methods:['POST', 'GET'])]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        if ($request->isMethod('POST') && $request->request->get('action') == 'buy') {
            $session = $request->getSession();
            $cart = $session->get('cart');
            $ids = array_map(function ($item) {
                return $item->getId();
            }, $cart);
            $items = $doctrine->getRepository(Item::class)->findBy(['id' => $ids]);
            $prixTotal = 0;
            foreach ($items as $item) {
                $prixTotal += $item->getPrix();
            }
            // On récupère l'argent de l'utilisateur connecté
            $user = new User();
            $userConnected = $this->getUser();
            $user = $userConnected;
            $argent = $user->getMonnaie();
            // On vérifie si l'utilisateur a assez d'argent
            if ($argent >= $prixTotal) {
                // On retire l'argent de l'utilisateur
                $argent -= $prixTotal;
                $user->setMonnaie($argent);
                $doctrine->getManager()->persist($user);
                $doctrine->getManager()->flush();
                // On retire les items du panier
                $session->remove('cart');
                $doctrine->getManager()->persist($user);
                $doctrine->getManager()->flush();
                $this->addFlash('success', 'Achat effectué avec succès');
            } else {
                $this->addFlash('error', 'Vous n\'avez pas assez d\'argent');
            }
        }
        if ($request->isMethod('POST') && $request->request->get('action') == 'delete') {
            $session = $request->getSession();
            $cart = $session->get('cart');
            $id = $request->request->get('id');
            $cart = array_filter($cart, function ($item) use ($id) {
                return $item->getId() != $id;
            });
            $session->set('cart', $cart);
            $this->addFlash('success', 'Item supprimé du panier');
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

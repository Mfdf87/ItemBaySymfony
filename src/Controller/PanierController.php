<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Item;
use App\Entity\User;
use App\Entity\AppartenanceItem;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier', methods:['POST', 'GET'])]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_connexion');
        }
        if ($request->isMethod('POST') && $request->request->get('action') == 'updateQuantity') {
            $session = $request->getSession();
            $id = $request->request->get('id');
            $quantite = $request->request->get('quantiteInCart');
            $session->set('quantiteInCart' . $id, $quantite);
            $this->addFlash('success', 'Quantité modifiée avec succès');
        }
        if ($request->isMethod('POST') && $request->request->get('action') == 'delete') {
            $session = $request->getSession();
            $cart = $session->get('cart');
            $id = $request->request->get('id');
            $cart = array_filter($cart, function ($item) use ($id) {
                return $item->getId() != $id;
            });
            $session->set('cart', $cart);
            // Flash message avec le nom de l'item supprimé
            $item = $doctrine->getRepository(Item::class)->find($id);
            $this->addFlash('success', $item->getNom() . ' a bien été supprimé du panier');
        }
        $items = $request->getSession()->get('cart');
        $quantiteInCart = [];
        foreach ($items as $item) {
            $quantiteInCart[$item->getId()] = $request->getSession()->get('quantiteInCart' . $item->getId());
        }
        foreach ($items as $item) {
            $item->quantiteInCart = $quantiteInCart[$item->getId()];
        }
        if (!$items || $request->request->get('from') == 'home') {
            return $this->redirectToRoute('home.index');
        }
        return $this->render('pages/panier/index.html.twig', [
            'controller_name' => 'PanierController',
            'items' => $items,
        ]);
    }


    #[Route('/panier/buy', name: 'app_panier_buy', methods:['GET'])]
    public function buy(Request $request, ManagerRegistry $doctrine): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_connexion');
        }
        $session = $request->getSession();
        $cart = $session->get('cart');
        $ids = array_map(function ($item) {
            return $item->getId();
        }, $cart);
        $items = $doctrine->getRepository(Item::class)->findBy(['id' => $ids]);

        // On récupère l'argent de l'utilisateur connecté
        $user = new User();
        $userConnected = $this->getUser();
        $user = $userConnected;
        $argent = $user->getMonnaie();

        $prixTotal = 0;
        // Le prix total est calculé en fonction de la quantité de chaque item multiplié par le prix de l'item
        foreach ($cart as $item) {
            if ($session->get('quantiteInCart' . $item->getId()) > $item->getQte()) {
                $this->addFlash('error', 'Vous ne pouvez pas acheter plus de ' . $item->getQte() . ' ' . $item->getNom() . 's');
                return $this->redirectToRoute('app_panier');
            }
            $prixTotal += $item->getPrix() * $session->get('quantiteInCart' . $item->getId());
        }

        // On vérifie si l'utilisateur a assez d'argent
        if ($argent >= $prixTotal) {
            foreach ($items as $item) {
                $appartenanceItem = $doctrine->getRepository(AppartenanceItem::class)->findOneBy(['idItem' => $item, 'idUser' => $user]);
                if (!$appartenanceItem) {
                    $appartenanceItem = new AppartenanceItem();
                    $appartenanceItem->setIdUser($user);
                    $appartenanceItem->setIdItem($item);
                    $appartenanceItem->setQuantite($session->get('quantiteInCart' . $item->getId()));
                } else {
                    $appartenanceItem->setQuantite($appartenanceItem->getQuantite() + $session->get('quantiteInCart' . $item->getId()));
                }
                $doctrine->getManager()->persist($appartenanceItem);

                $item->setQte($item->getQte() - $session->get('quantiteInCart' . $item->getId()));
                $doctrine->getManager()->persist($item);

                $doctrine->getManager()->flush();
            }
            // On retire l'argent de l'utilisateur
            $argent -= $prixTotal;
            $user->setMonnaie($argent);
            $doctrine->getManager()->persist($user);
            $doctrine->getManager()->flush();
            // On retire les items du panier
            $session->remove('cart');
            $doctrine->getManager()->persist($user);
            $doctrine->getManager()->flush();

            // On ajoute les items au joueur dans la table appartenanceItem
            $this->addFlash('success', 'Achat effectué avec succès');
        }
        else {
            $this->addFlash('error', 'Vous n\'avez pas assez d\'argent');
        }
        return $this->redirectToRoute('app_items_user');
    }
}

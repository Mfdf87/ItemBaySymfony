<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Item;
use App\Entity\AppartenanceItem;

class ItemController extends AbstractController
{
    #[Route('/item', name: 'item', methods: ['POST'])]
    public function index(\App\Repository\ItemRepository $itemRepository, Request $request, ManagerRegistry $doctrine): Response
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
            // On vérifie que l'utilisateur est bien un admin
            if (!$this->isGranted('ROLE_ADMIN')) {
                // Sinon on le redirige vers la page d'accueil
                $this->addFlash('danger', 'Vous n\'avez pas les droits pour accéder à cette page');
                return $this->redirectToRoute('home.index');
            }
            else {
                deleteItem($item, $doctrine);
                $this->addFlash('success', 'L\'item a bien été supprimé');
                return $this->redirectToRoute('app_gest_boutique');
            }
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

            $this->addFlash('success', $item->getNom() . ' a bien été ajouté au panier');

            // On redirige vers la page d'accueil
            return $this->redirectToRoute('home.index');
        }
    }
}

function deleteItem($item, $doctrine){
    // On va supprimer l'item dans tout les endroits dans lesquel il est présent dans appartenanceItem
    $appartenanceItem = $doctrine->getRepository(AppartenanceItem::class)->findBy(['idItem' => $item]);
    foreach ($appartenanceItem as $appartenance) {
        $doctrine->getManager()->remove($appartenance);
    }
    $doctrine->getManager()->flush();
    // On supprime l'item
    $doctrine->getManager()->remove($item);
    $doctrine->getManager()->flush();
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\AppartenanceItem;
use App\Entity\User;
use App\Entity\Item;
use Doctrine\Persistence\ManagerRegistry;

class ItemsUserController extends AbstractController
{
    #[Route('/items/user', name: 'app_items_user')]
    public function index(ManagerRegistry $doctrine): Response
    {
        // On récupère tout les items de l'utilisateur connecté
        // Les items sont présent dans la table AppartenanceItem
        $user = new User();
        $userConnected = $this->getUser();
        $user = $userConnected;
        $idUser = $user->getId();
        $items = $doctrine->getRepository(AppartenanceItem::class)->findBy(['idUser' => $idUser]);
        // Dans items, nous avons l'id de l'item et la quantité
        // On va chercher les items dans la table Item
        $items2 = [];
        foreach ($items as $item) {
            $idItem = $item->getIdItem();
            $item2 = $doctrine->getRepository(Item::class)->find($idItem);
            $items2[] = $item2;
        }
        $items = $items2;
        // On va mettre la quantité des items de l'utilisateur de la table AppartenanceItem dans le tableau items
        $i = 0;
        foreach ($items as $item) {
            $idItem = $item->getId();
            $item2 = $doctrine->getRepository(AppartenanceItem::class)->findOneBy(['idItem' => $idItem]);
            $quantite = $item2->getQuantite();
            $items[$i]->setQte($quantite);
            $i++;
        }
        return $this->render('pages/items_user/index.html.twig', [
            'controller_name' => 'ItemsUserController',
            'items' => $items,
        ]);
    }
}

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
            $session->set('quantiteInCart' . $item->getId(), 1);

            $this->addFlash('success', $item->getNom() . ' a bien été ajouté au panier');

            // On redirige vers la page d'accueil
            return $this->redirectToRoute('home.index');
        }
    }

    // Route pour créer un item
    #[Route('/item/create', name: 'item_create', methods: ['POST', 'GET'])]
    public function create(ManagerRegistry $doctrine): Response
    {
        // On vérifie que l'utilisateur est bien un admin
        if (!$this->isGranted('ROLE_ADMIN')) {
            // Sinon on le redirige vers la page d'accueil
            $this->addFlash('error', 'Vous n\'avez pas les droits pour accéder à cette page');
            return $this->redirectToRoute('home.index');
        }
        else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nom = $_POST['nom'];
            $description = $_POST['description'];
            $prix = $_POST['prix'];
            $qte = $_POST['qte'];
            $stats = $_POST['stats'];
            if ($_FILES['image']['name'] != "") {
                $image = uploadImageItem($_FILES['image']);
            }
            else {
                $image = "Defaut.png";
            }
            createItem($doctrine, $nom, $description, $prix, $qte, $stats, $image);
            $this->addFlash('success', 'L\'item a bien été créé');
            return $this->redirectToRoute('app_gest_boutique');
        }
        else {
            return $this->render('pages/item/update.html.twig', [
                'create' => 'true',
            ]);
        }
    }

    #[Route('/item/update', name: 'item_update', methods: ['POST', 'GET'])]
    public function update(\App\Repository\ItemRepository $itemRepository, Request $request, ManagerRegistry $doctrine): Response
    {
        // On vérifie que l'utilisateur est bien un admin
        if (!$this->isGranted('ROLE_ADMIN')) {
            // Sinon on le redirige vers la page d'accueil
            $this->addFlash('error', 'Vous n\'avez pas les droits pour accéder à cette page');
            return $this->redirectToRoute('home.index');
        }
        else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $nom = $_POST['nom'];
            $description = $_POST['description'];
            $prix = $_POST['prix'];
            $qte = $_POST['qte'];
            $stats = $_POST['stats'];
            if ($_FILES['image']['name'] != "") {
                $item = $itemRepository->find($id);
                $oldImage = $item->getUrl();
                $imageName = uploadImageItem($_FILES['image'], true, $oldImage);
            }
            else if ($_POST['old_image'] != "") {
                $imageName = $_POST['old_image'];
            }
            else {
                $imageName = "Defaut.png";
            }
            updateItem($doctrine, $id, $nom, $description, $prix, $qte, $stats, $imageName);
            $this->addFlash('success', 'L\'item a bien été modifié');
            return $this->redirectToRoute('app_gest_boutique');
        }
        else {
            $id = $_GET['id'];
            $item = $itemRepository->find($id);
            return $this->render('pages/item/update.html.twig', [
                'item' => $item,
                'update' => 'true',
            ]);
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

    // On supprime l'image de l'item
    if ($item->getUrl() != "Defaut.png") {
        try {
            unlink('images/items/' . $item->getUrl());
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    // On supprime l'item
    $doctrine->getManager()->remove($item);
    $doctrine->getManager()->flush();
}

function createItem($doctrine, $nom, $description, $prix, $qte, $stats, $image){
    $item = new Item();
    $item->setNom($nom);
    $item->setDescription($description);
    $item->setPrix($prix);
    $item->setQte($qte);
    $item->setStat($stats);
    $item->setUrl($image);
    $item->setCreatedAt(new \DateTimeImmutable());
    $doctrine->getManager()->persist($item);
    $doctrine->getManager()->flush();
}

function updateItem($doctrine, $id, $nom, $description, $prix, $qte, $stats, $image){
    $item = $doctrine->getRepository(Item::class)->find($id);
    $item->setNom($nom);
    $item->setDescription($description);
    $item->setPrix($prix);
    $item->setQte($qte);
    $item->setStat($stats);
    $item->setUrl($image);
    $doctrine->getManager()->flush();
}

// Fonction upload item qui prend un type file en paramètre
function uploadImageItem($image, $isModify = false, $oldImage = null){
    if ($isModify && $oldImage != "Defaut.png") {
        unlink('images/items/' . $oldImage);
    }
    $imageName = $image['name'];
    $imagePath = $image['tmp_name'];
    $imageSize = $image['size'];
    $imageExtension = strtolower(substr(strrchr($imageName,'.'),1));
    $extensionValide = array('jpg', 'jpeg', 'png');
    if (in_array($imageExtension, $extensionValide)) {
        if ($imageSize <= 2000000) {
            $imageFolder = 'images/items/';
            $imageName = time() . "_" . $imageName;
            $imagePath = $imageFolder . $imageName;
            move_uploaded_file($image['tmp_name'], $imagePath);
        }
    }
    return $imageName;
}

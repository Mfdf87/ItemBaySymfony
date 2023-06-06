<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\TypeItem;

class TypeItemController extends AbstractController
{
    #[Route('/type/item/show', name: 'type_item_show', methods: ['GET'])]
    public function show(ManagerRegistry $doctrine): Response
    {
        // On récupère le manager de Doctrine
        $manager = $doctrine->getManager();

        // On récupère tous les types d'items
        $typesItems = $manager->getRepository(TypeItem::class)->findAll();

        // On affiche la page de liste des types d'items
        return $this->render('pages/type_item/show.html.twig', [
            'typesItems' => $typesItems
        ]);
    }
    
    #[Route('/type/item/create', name: 'type_item_create', methods: ['POST', 'GET'])]
    public function create(ManagerRegistry $doctrine): Response
    {
        // On vérifie que l'utilisateur est bien un admin
        if (!$this->isGranted('ROLE_ADMIN')) {
            // Sinon on le redirige vers la page d'accueil
            $this->addFlash('danger', 'Vous n\'avez pas les droits pour accéder à cette page');
            return $this->redirectToRoute('home.index');
        }
        else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // On récupère les données du formulaire
            $nomTypeItem = $_POST['nom_type_item'];

            if ($_FILES['icon']['name'] != "") {
                $icon = uploadTypeItemImage($_FILES['icon'], $nomTypeItem);
            }
            else {
                $icon = "armure.png";
            }

            // On vérifie que les données sont valides
            if (empty($nomTypeItem) || empty($icon)) {
                $this->addFlash('danger', 'Veuillez remplir tous les champs');
                return $this->redirectToRoute('type_item_create');
            }

            // On récupère le manager de Doctrine
            $manager = $doctrine->getManager();

            // On crée un nouveau type d'item
            $typeItem = new TypeItem();
            $typeItem->setNomTypeItem($nomTypeItem);
            $typeItem->setIcon($icon);

            // On sauvegarde le nouveau type d'item
            $manager->persist($typeItem);
            $manager->flush();

            // On redirige vers la page de création d'un type d'item
            $this->addFlash('success', 'Le type d\'item a bien été créé');
            return $this->redirectToRoute('type_item_show');
        }
        else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            return $this->render('pages/type_item/create.html.twig', [
                'controller_name' => 'TypeItemController',
                'create' => true
            ]);
        }
    }

    #[Route('/type/item/modify/{id}', name: 'type_item_modify', methods: ['POST', 'GET'])]
    public function modify(ManagerRegistry $doctrine, $id): Response
    {
        // On vérifie que l'utilisateur est bien un admin
        if (!$this->isGranted('ROLE_ADMIN')) {
            // Sinon on le redirige vers la page d'accueil
            $this->addFlash('danger', 'Vous n\'avez pas les droits pour accéder à cette page');
            return $this->redirectToRoute('home.index');
        }
        else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // On récupère les données du formulaire
            $nomTypeItem = $_POST['nom_type_item'];
            $oldImage = $_POST['old_image'];

            if ($_FILES['icon']['name'] != "") {
                $icon = uploadTypeItemImage($_FILES['icon'], $nomTypeItem, true, $oldImage);
            }
            else {
                $icon = $oldImage;
            }

            // On vérifie que les données sont valides
            if (empty($nomTypeItem) || empty($icon)) {
                $this->addFlash('danger', 'Veuillez remplir tous les champs');
                return $this->redirectToRoute('type_item_modify', ['id' => $id]);
            }

            // On récupère le manager de Doctrine
            $manager = $doctrine->getManager();

            // On récupère le type d'item à modifier
            $typeItem = $manager->getRepository(TypeItem::class)->find($id);

            // On modifie le type d'item
            $typeItem->setNomTypeItem($nomTypeItem);
            $typeItem->setIcon($icon);

            // On sauvegarde le type d'item
            $manager->persist($typeItem);
            $manager->flush();

            // On redirige vers la page de modification d'un type d'item
            $this->addFlash('success', 'Le type d\'item a bien été modifié');
            return $this->redirectToRoute('type_item_show', ['id' => $id]);
        }
        else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            // On récupère le manager de Doctrine
            $manager = $doctrine->getManager();

            // On récupère le type d'item à modifier
            $typeItem = $manager->getRepository(TypeItem::class)->find($id);

            return $this->render('pages/type_item/create.html.twig', [
                'controller_name' => 'TypeItemController',
                'create' => false,
                'typeItem' => $typeItem
            ]);
        }
    }

    #[Route('/type/item/delete/{id}', name: 'type_item_delete', methods: ['GET'])]
    public function delete(ManagerRegistry $doctrine, $id): Response
    {
        // On vérifie que l'utilisateur est bien un admin
        if (!$this->isGranted('ROLE_ADMIN')) {
            // Sinon on le redirige vers la page d'accueil
            $this->addFlash('danger', 'Vous n\'avez pas les droits pour accéder à cette page');
            return $this->redirectToRoute('home.index');
        }
        else {
            // On récupère le manager de Doctrine
            $manager = $doctrine->getManager();

            // On récupère le type d'item à supprimer
            $typeItem = $manager->getRepository(TypeItem::class)->find($id);

            // Si jamais le type d'item est déjà utilisé par un item, on renvoit vers la page de liste des types d'items avec un message d'erreur
            if (count($typeItem->getItems()) > 0) {
                $this->addFlash('danger', 'Le type d\'item est déjà utilisé par un item');
                return $this->redirectToRoute('type_item_show');
            }

            // On supprime l'image du type d'item
            if ($typeItem->getIcon() != "Defaut.png") {
                try {
                    unlink('images/type_items/' . $typeItem->getIcon());
                }
                catch (\Exception $e) {
                }
            }

            // On supprime le type d'item
            $manager->remove($typeItem);
            $manager->flush();

            // On redirige vers la page de liste des types d'items
            $this->addFlash('success', 'Le type d\'item a bien été supprimé');
            return $this->redirectToRoute('type_item_show');
        }
    }
}

function uploadTypeItemImage($image, $nomTypeItem, $isModify = false, $oldImage = null, ){
    if ($isModify && $oldImage != "Defaut.png") {
        try {
            unlink('images/type_items/' . $oldImage);
        }
        catch (\Exception $e) {
        }
    }
    $imageName = $image['name'];
    $imagePath = $image['tmp_name'];
    $imageSize = $image['size'];
    $imageExtension = strtolower(substr(strrchr($imageName,'.'),1));
    $extensionValide = array('jpg', 'jpeg', 'png');
    if (in_array($imageExtension, $extensionValide)) {
        if ($imageSize <= 2000000) {
            $imageFolder = 'images/type_items/';
            $imageName = time() . "_" . $nomTypeItem . "." . $imageExtension;
            $imagePath = $imageFolder . $imageName;
            move_uploaded_file($image['tmp_name'], $imagePath);
        }
    }
    return $imageName;
}

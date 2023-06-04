<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'profil', methods: ['GET', 'POST'])]
    public function index(\App\Repository\UserRepository $userRepository): Response
    {        
        // On vérifie que l'utilisateur est connecté
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // On récupère l'id de l'user en post si il existe
        $id = $_POST['id'] ?? null;

        if ($id != null && $this->isGranted('ROLE_ADMIN')) {
            $user = $userRepository->find($id);

            return $this->render('pages/profil/index.html.twig', [
                'controller_name' => 'ProfilController',
                'user' => $user
            ]);
        }
        else if ($id != null && !$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_connexion');
        }
        else {
            $user = $this->getUser();
            return $this->render('pages/profil/index.html.twig', [
                'controller_name' => 'ProfilController',
                'user' => $user
            ]);
        }
    }

    #[Route('/profil/update/{id}', name: 'profil_update', methods: ['GET', 'POST'])]
    public function update(\App\Repository\UserRepository $userRepository, $id, ManagerRegistry $doctrine): Response
    {
        // On vérifie que l'utilisateur est connecté
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // Si nous sommes en post, on récupère les données
        if ($_POST){
            $id = $_POST['id'];
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];

            // Si l'utilisateur connecté n'est pas un admin, on vérifie que l'id de l'utilisateur connecté est le même que celui passé en paramètre
            if (!$this->isGranted('ROLE_ADMIN')) {
                $user = $this->getUser();
                if ($user->getId() != $id) {
                    $this->addFlash('error', 'Vous n\'avez pas les droits pour modifier ce compte');
                    return $this->redirectToRoute('profil');
                }
                // Il faut aussi vérifier que l'email n'est pas déjà utilisé
                $user = $userRepository->findOneBy(['email' => $email]);
                if ($user != null && $user->getId() != $id) {
                    $this->addFlash('error', 'Cet email est déjà utilisé');
                    return $this->redirectToRoute('profil');
                }

                // On récupère l'utilisateur connecté
                $user = $this->getUser();
                $user->setNom($nom);
                $user->setPrenom($prenom);
                $user->setEmail($email);
                if (isset($_FILES['photo']) && $_FILES['photo']['name'] != "") {
                    $old_photo = $user->getPhoto();
                    $newPhotoName = uploadPhotoUser($_FILES['photo'], $user, $doctrine, $old_photo);
                    $user->setPhoto($newPhotoName);
                }
                // On enregistre les modifications en base de données
                $em = $doctrine->getManager();
                $em->persist($user);
                $em->flush();
                $this->addFlash('success', 'Votre compte a bien été modifié');
                return $this->redirectToRoute('profil');
            }
            else if ($this->isGranted('ROLE_ADMIN')) {
                // On vérifie que l'email n'est pas déjà utilisé par un autre utilisateur
                $user = $userRepository->findOneBy(['email' => $email]);
                if ($user != null && $user->getId() != $id) {
                    $this->addFlash('error', 'Cet email est déjà utilisé');
                    return $this->redirectToRoute('app_gest_cmpt');
                }

                $user = $userRepository->find($id);
                $user->setNom($nom);
                $user->setPrenom($prenom);
                $user->setEmail($email);
                if (isset($_FILES['photo']) && $_FILES['photo']['name'] != "") {
                    $old_photo = $user->getPhoto();
                    $user->setPhoto(uploadPhotoUser($_FILES['photo'], $user, $doctrine, $old_photo));
                }

                $em = $doctrine->getManager();
                $em->persist($user);
                $em->flush();
                $this->addFlash('success', 'Le compte a bien été modifié');
                return $this->redirectToRoute('app_gest_cmpt');
            }
        }

        // On récupère l'id en paramètre GET
        $id = $id ?? null;

        // On affiche la page update.html.twig si l'utilisateur est admin
        if ($id != null && $this->isGranted('ROLE_ADMIN')) {
            $user = $userRepository->find($id);

            return $this->render('pages/gest_cmpt/update.html.twig', [
                'controller_name' => 'ProfilController',
                'user' => $user,
            ]);
        }

        // Si jamais l'utilisateur n'est pas admin, on vérifie que l'id de l'utilisateur connecté est le même que celui passé en paramètre
        if (!$this->isGranted('ROLE_ADMIN')) {
            $user = $this->getUser();
            if ($user->getId() != $id) {
                $this->addFlash('error', 'Vous n\'avez pas les droits pour modifier ce compte');
                return $this->redirectToRoute('profil');
            }
            else {
                return $this->render('pages/gest_cmpt/update.html.twig', [
                    'controller_name' => 'ProfilController',
                    'user' => $user,
                ]);
            }
        }
    }

    #[Route('/profil/delete/{id}', name: 'profil_delete', methods: ['GET'] )]
    public function deleteUser(\App\Repository\UserRepository $userRepository, $id, ManagerRegistry $doctrine): Response
    {
        // On vérifie que l'utilisateur est admin
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // On récupère l'id en paramètre GET
        $id = $id ?? null;

        // On vérifie que l'utilisateur est admin et que l'utilisateur à supprimer n'est pas celui connecté
        if ($id != null && $this->isGranted('ROLE_ADMIN') && $this->getUser()->getId() != $id) {
            $user = $userRepository->find($id);

            $em = $doctrine->getManager();
            $em->remove($user);
            $em->flush();
            $this->addFlash('success', 'Le compte a bien été supprimé');
            return $this->redirectToRoute('app_gest_cmpt');
        }
        else {
            if ($this->getUser()->getId() == $id) {
                $this->addFlash('error', 'Vous ne pouvez pas supprimer votre propre compte');
            }
            else{
                $this->addFlash('error', 'Vous n\'avez pas les droits pour supprimer ce compte');
            }
            return $this->redirectToRoute('profil');
        }
    }
}

// Prend un type file en paramètre pour photo
function uploadPhotoUser($photo, $user, $doctrine, $old_photo){
    if ($old_photo != null) {
        unlink('images/utilisateurs/' . $old_photo);
    }
    $photoName = $photo['name'];
    $photoPath = $photo['tmp_name'];
    $photoSize = $photo['size'];
    $photoExtension = strtolower(substr(strrchr($photoName,'.'),1));
    $extensionValide = array('jpg', 'jpeg', 'png');
    if (in_array($photoExtension, $extensionValide)) {
        if ($photoSize <= 2000000) {
            $photoFolder = 'images/utilisateurs/';
            $photoName = time() . "_" . $photoName;
            $photoPath = $photoFolder . $photoName;
            move_uploaded_file($photo['tmp_name'], $photoPath);
            $user->setPhoto($photoName);
            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();
        }
    }
    return $photoName;
}

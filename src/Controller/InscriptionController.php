<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Utils\EmailValidator;
use App\Utils\PasswordValidator;
use App\Entity\Compte;
use Doctrine\ORM\EntityManagerInterface;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function index(): Response
    {
        return $this->render('pages/inscription/index.html.twig', [
            'controller_name' => 'InscriptionController',
        ]);
    }

    #[Route('/register', name: 'app_register', methods: ['POST'])]
    public function register(Request $request, EntityManagerInterface $entityManager): Response
    {
        $email = $request->request->get('email');
        $password = $request->request->get('password');
        $nom = $request->request->get('name');
        $surname = $request->request->get('surname');

        if (!EmailValidator::isValidEmail($email)) {
            // On renvoit sur la page d'inscription avec un message d'erreur
            return $this->redirectToRoute('app_inscription', [
                'error' => 'L\'adresse email n\'est pas valide'
            ]);
        }

        $passwordError = PasswordValidator::isValidPassword($password);
        if ($passwordError !== true) {
            // On renvoit sur la page d'inscription avec un message d'erreur
            return $this->redirectToRoute('app_inscription', [
                'error' => $passwordError
            ]);
        }

        // On vérifie que l'email n'est pas déjà utilisé
        if (EmailValidator::isEmailInBDD($email, $entityManager)) {
            // On renvoit sur la page d'inscription avec un message d'erreur
            return $this->redirectToRoute('app_inscription', [
                'error' => 'L\'adresse email est déjà utilisée'
            ]);
        }

        // On crée un nouveau compte
        $compte = new Compte();
        $compte->setEmail($email);
        $compte->setPassword(password_hash($password, PASSWORD_DEFAULT));
        $compte->setNom($nom);
        $compte->setPrenom($surname);
        $compte->setIsAdmin(false);
        $compte->setMonnaie(10);

        // On sauvegarde le compte en BDD
        $entityManager->persist($compte);
        $entityManager->flush();

        // On redirige vers la page de connexion
        return $this->redirectToRoute('app_connexion');
    }
}

<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    #[Route('/logout', name: 'app_deconnexion', methods: ['GET'])]
    public function logout()
    {
        throw new \Exception('Ne pas oublier de configurer votre fichier security.yaml');
    }
}
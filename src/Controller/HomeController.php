<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function home(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        return $this->render('home.html.twig', [
        ]);
    }
}
<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', 'home.index', methods: ['GET'])]
    public function index() :Response
    {
        return $this->render('home.html.twig');
    }

    /** Route vers un la page information  */
    #[Route('/information', 'information', methods: ['GET'])] /** Indique les information de l'url  */
    public function information() :Response // Apelle de fonction 
    {
        return $this->render('Information.html.twig'); //sert à faire le lien 
    }

}

?>
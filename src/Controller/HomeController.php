<?php

namespace App\Controller;

use App\Repository\ItemRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', 'home.index', methods: ['GET'])]
    public function index(ItemRepository $repository) :Response
    {
        $items = $repository->findAll();
        // On enlève les items dont la quantité est nulle ou négative
        $items = array_filter($items, function ($item) {
            return $item->getQte() > 0;
        });
        return $this->render('pages/home.html.twig', [
            'items' => $items,
        ]);
    }
}

?>
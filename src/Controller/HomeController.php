<?php

namespace App\Controller;

use App\Entity\Item;
use App\Repository\ItemRepository;
use App\Repository\TypeItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', 'home.index', methods: ['GET'])]
    public function index(ItemRepository $repository, EntityManagerInterface $entityManagerInterface,TypeItemRepository $typeItemRepository) :Response
    {
        $repository = $entityManagerInterface->getRepository(Item::class);
        $items = $repository->createQueryBuilder('item')
            ->leftJoin('item.typeItem', 'typeItem')
            ->select('item', 'typeItem')
            ->getQuery()
            ->getResult();

        $typeItems = $typeItemRepository->findAll();
        // On enlève les items dont la quantité est nulle ou négative
        $items = array_filter($items, function ($item) {
            return $item->getQte() > 0;
        });
        return $this->render('pages/home.html.twig', [
            'items' => $items,
            'typeItems' => $typeItems
        ]);
    }
}

?>
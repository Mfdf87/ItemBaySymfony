<?php

namespace App\Controller;

use App\Entity\Enigme;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QueteController extends AbstractController
{
    #[Route('/quete', name: 'app_quete',methods: ['GET','POST'])]
    public function index(EntityManagerInterface $entityManager,Request $request): Response
    {
        //recuperer l'id de l'utilisateur connecté
        $user = $this->getUser();

        return $this->render('quete/index.html.twig', [
            'controller_name' => 'QueteController',
            'quete' => $user->getQuete(),
        ]);
    }

    #[Route('/queterandom/{difficulte}', name: 'app_random',methods: 'GET')]
    public function randomEnigme(EntityManagerInterface $entityManager,int $difficulte): Response
    {
        $enigme = $entityManager->getRepository(Enigme::class)->getEnigmeAleatoire($difficulte);
        json_encode($enigme);
        return $this->json($enigme);
    }
    
    public function requeteSql(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $user->setQuete(1);
        $entityManager->persist($user);
        $entityManager->flush();
        $this->ajoutMonnaie($entityManager);
        return $this->redirectToRoute('app_quete');
    }
    #[Route('ajout_monnaie', name: 'ajout_monnaie',methods: ['GET','POST'])]
    public function ajoutMonnaie(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $nbmonnaie = $user->getMonnaie();
        $user->setMonnaie($nbmonnaie + 10);
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirectToRoute('app_quete');
    }
}

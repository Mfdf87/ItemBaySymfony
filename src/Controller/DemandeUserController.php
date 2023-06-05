<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\DemandeAdmin;

class DemandeUserController extends AbstractController
{
    #[Route('/demande/user', name: 'app_demande_user')]
    public function index(ManagerRegistry $doctrine): Response
    {
        if (!$this->isGranted('ROLE_USER')) {
            $this->addFlash('danger', 'Vous n\'avez pas accès à cette page');
            return $this->redirectToRoute('home.index');
        }
        // On récupère les demandes qui ont été créé par l'utilisateur connecté
        $demandesUser = $doctrine->getRepository(DemandeAdmin::class)->findBy([
            'CreatedBy' => $this->getUser()
        ]);

        $demandesUser = array_map(function($demandeUser) {
            switch ($demandeUser->getTypeDemande()) {
                case 1:
                    $demandeUser->nomTypeDemande = 'Indiquer un bug';
                    break;
                case 2:
                    $demandeUser->nomTypeDemande = 'Demander de l\'argent';
                    break;
                case 3:
                    $demandeUser->nomTypeDemande = 'Signaler un joueur';
                    break;
                default:
                    $demandeUser->nomTypeDemande = 'Type de demande inconnue';
                    break;
            }
            return $demandeUser;
        }, $demandesUser);

        $demandesUser = array_filter($demandesUser, function($demandeUser) {
            return $demandeUser->nomTypeDemande != 'Type de demande inconnue';
        });

        $demandesUser = array_map(function($demandeUser) {
            switch ($demandeUser->isAccept()) {
                case 0:
                    // Si jamais validatedBy est null, on met en attente
                    if ($demandeUser->getValidatedBy() == null) {
                        $demandeUser->statutAccept = 'En attente';
                        $demandeUser->statutClass = 'warning';
                        break;
                    }
                    else {
                        $demandeUser->statutAccept = 'Refusée';
                        $demandeUser->statutClass = 'danger';
                    }
                    break;
                case 1:
                    $demandeUser->statutAccept = 'Acceptée';
                    $demandeUser->statutClass = 'success';
                    break;
                default:
                    $demandeUser->statutAccept = 'Statut inconnu';
                    break;
            }
            return $demandeUser;
        }, $demandesUser);

        return $this->render('pages/demande_user/index.html.twig', [
            'controller_name' => 'DemandeUserController',
            'demandes' => $demandesUser
        ]);
    }
}

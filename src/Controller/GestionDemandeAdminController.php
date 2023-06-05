<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\DemandeAdmin;
use Doctrine\Persistence\ManagerRegistry;

class GestionDemandeAdminController extends AbstractController
{
    #[Route('/gestion/demande/admin', name: 'app_gestion_demande_admin')]
    public function index(ManagerRegistry $doctrine): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('danger', 'Vous n\'avez pas accès à cette page');
            return $this->redirectToRoute('home.index');
        }

        // On récupère toutes les demandes d'admin de la base de données de la table DemandeAdmin
        $demandesAdmin = $doctrine->getRepository(DemandeAdmin::class)->findAll();
        $demandesAdmin = array_filter($demandesAdmin, function($demandeAdmin) {
            return $demandeAdmin->isAccept() != 1;
        });

        $demandesAdmin = array_map(function($demandeAdmin) {
            switch ($demandeAdmin->getTypeDemande()) {
                case 1:
                    $demandeAdmin->nomTypeDemande = 'Indiquer un bug';
                    break;
                case 2:
                    $demandeAdmin->nomTypeDemande = 'Demander de l\'argent';
                    break;
                case 3:
                    $demandeAdmin->nomTypeDemande = 'Signaler un joueur';
                    break;
                default:
                    $demandeAdmin->nomTypeDemande = 'Type de demande inconnue';
                    break;
            }
            return $demandeAdmin;
        }, $demandesAdmin);

        $demandesAdmin = array_filter($demandesAdmin, function($demandeAdmin) {
            return $demandeAdmin->nomTypeDemande != 'Type de demande inconnue';
        });
        
        $demandesAdmin = array_filter($demandesAdmin, function($demandeAdmin) {
            return $demandeAdmin->getValidatedBy() == null;
        });

        usort($demandesAdmin, function($a, $b) {
            if ($a->getDateSubmition() == $b->getDateSubmition()) {
                return strcmp($a->nomTypeDemande, $b->nomTypeDemande);
            }
            return $a->getDateSubmition() < $b->getDateSubmition() ? -1 : 1;
        });

        return $this->render('pages/gestion_demande_admin/index.html.twig', [
            'controller_name' => 'GestionDemandeAdminController',
            'demandes' => $demandesAdmin
        ]);
    }

    #[Route('/gestion/demande/admin/accept/{id}', name: 'app_gestion_demande_admin_accept', methods: ['GET'])]
    public function accept(ManagerRegistry $doctrine, int $id): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('danger', 'Vous n\'avez pas accès à cette page');
            return $this->redirectToRoute('home.index');
        }

        $demandeAdmin = $doctrine->getRepository(DemandeAdmin::class)->find($id);
        $demandeAdmin->setAccept(true);
        $demandeAdmin->setValidatedBy($this->getUser());
        $doctrine->getManager()->flush();

        $this->addFlash('success', 'La demande a bien été acceptée');
        return $this->redirectToRoute('app_gestion_demande_admin');
    }

    #[Route('/gestion/demande/admin/refuse/{id}', name: 'app_gestion_demande_admin_refuse', methods: ['GET'])]
    public function refuse(ManagerRegistry $doctrine, int $id): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('danger', 'Vous n\'avez pas accès à cette page');
            return $this->redirectToRoute('home.index');
        }

        $demandeAdmin = $doctrine->getRepository(DemandeAdmin::class)->find($id);
        $demandeAdmin->setAccept(false);
        $demandeAdmin->setValidatedBy($this->getUser());
        $doctrine->getManager()->flush();

        $this->addFlash('success', 'La demande a bien été refusée');
        return $this->redirectToRoute('app_gestion_demande_admin');
    }
}

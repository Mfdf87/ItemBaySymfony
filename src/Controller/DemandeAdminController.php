<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\DemandeAdmin;
use App\Entity\User;

class DemandeAdminController extends AbstractController
{
    #[Route('/demande/admin', name: 'app_demande_admin', methods: ['GET', 'POST'])]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        if ($request->isMethod('GET')){
            $typeDemande = "";
            switch ($request->query->get('id')) {
                case 1:
                    $typeDemande = "Indiquer un bug";
                    break;
                case 2:
                    if (!$this->getUser()) {
                        $this->addFlash('danger', 'Vous devez être connecté pour accéder à cette page');
                        return $this->redirectToRoute('app_connexion');
                    }
                    $typeDemande = "Demander de l'argent";
                    break;
                case 3:
                    if (!$this->getUser()) {
                        $this->addFlash('danger', 'Vous devez être connecté pour accéder à cette page');
                        return $this->redirectToRoute('app_connexion');
                    }
                    $typeDemande = "Signaler un joueur";
                    break;
                default:
                    $this->addFlash('danger', 'Type de demande inconnue');
                    return $this->redirectToRoute('support_admin');
                    break;
            }
            return $this->render('pages/demande_admin/index.html.twig', [
                'controller_name' => 'DemandeAdminController',
                'id' => $request->query->get('id'),
                'typeDemande' => $typeDemande
            ]);
        }
        else if ($request->isMethod('POST')){
            //dd($_POST);
            $idDemande = $_POST['idDemande'];
            switch ($idDemande) {
                case 1:
                    if (!isset($_POST['description']) || empty($_POST['description'])) {
                        $this->addFlash('danger', 'Vous devez remplir tous les champs');
                        return $this->redirectToRoute('app_demande_admin', ['id' => $idDemande]);
                    }
                    $description = $_POST['description'];
                    $demandeAdmin = new DemandeAdmin();
                    $demandeAdmin->setDateSubmition(new \DateTime());
                    $demandeAdmin->setAccept(false);
                    $demandeAdmin->setDescription($description);
                    $demandeAdmin->setTypeDemande($idDemande);

                    $entityManager = $doctrine->getManager();
                    $entityManager->persist($demandeAdmin);
                    $entityManager->flush();

                    $this->addFlash('success', 'Votre demande a bien été envoyée');
                    return $this->redirectToRoute('support_admin');
                    break;
                case 2:
                    if (!$this->getUser()) {
                        $this->addFlash('danger', 'Vous devez être connecté pour accéder à cette page');
                        return $this->redirectToRoute('app_connexion');
                    }
                    if (!isset($_POST['description']) || empty($_POST['description']) || !isset($_POST['somme']) || empty($_POST['somme'])) {
                        $this->addFlash('danger', 'Vous devez remplir tous les champs');
                        return $this->redirectToRoute('app_demande_admin', ['id' => $idDemande]);
                    }
                    $description = $_POST['description'];
                    $somme = $_POST['somme'];
                    $demandeAdmin = new DemandeAdmin();
                    $demandeAdmin->setDateSubmition(new \DateTime());
                    $demandeAdmin->setAccept(false);
                    $demandeAdmin->setDescription($description);
                    $demandeAdmin->setSomme($somme);
                    $demandeAdmin->setTypeDemande($idDemande);
                    $demandeAdmin->setCreatedBy($this->getUser());
                    
                    $entityManager = $doctrine->getManager();
                    $entityManager->persist($demandeAdmin);
                    $entityManager->flush();

                    $this->addFlash('success', 'Votre demande a bien été envoyée');
                    return $this->redirectToRoute('support_admin');
                    break;
                case 3:
                    if (!$this->getUser()) {
                        $this->addFlash('danger', 'Vous devez être connecté pour accéder à cette page');
                        return $this->redirectToRoute('app_connexion');
                    }
                    if (!isset($_POST['joueur']) || empty($_POST['joueur']) || !isset($_POST['raison']) || empty($_POST['raison'])) {
                        $this->addFlash('danger', 'Vous devez remplir tous les champs');
                        return $this->redirectToRoute('app_demande_admin', ['id' => $idDemande]);
                    }
                    $joueur = $_POST['joueur'];
                    $user = $doctrine->getRepository(User::class)->findOneBy(['Nom' => $joueur]);
                    if (!$user) {
                        $this->addFlash('danger', 'Le joueur n\'existe pas');
                        return $this->redirectToRoute('app_demande_admin', ['id' => $idDemande]);
                    }
                    $raison = $_POST['raison'];
                    $demandeAdmin = new DemandeAdmin();
                    $demandeAdmin->setDateSubmition(new \DateTime());
                    $demandeAdmin->setAccept(false);
                    $demandeAdmin->setDescription($raison);
                    $demandeAdmin->setTypeDemande($idDemande);
                    $demandeAdmin->setCreatedBy($this->getUser());
                    $demandeAdmin->setNomJoueur($joueur);

                    $entityManager = $doctrine->getManager();
                    $entityManager->persist($demandeAdmin);
                    $entityManager->flush();

                    $this->addFlash('success', 'Votre demande a bien été envoyée');
                    return $this->redirectToRoute('support_admin');
                    break;
                default:
                    $this->addFlash('danger', 'Type de demande inconnue');
                    return $this->redirectToRoute('support_admin');
                    break;
            }
        }
    }
}

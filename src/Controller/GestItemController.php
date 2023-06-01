<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class GestItemController extends AbstractController
{
    #[Route('/gest/item', name: 'app_gest_item')]
    public function index(Request $request): Response
    {
        $nom = $request->request->get('nom', '');
        $description = $request->request->get('description', '');
        $quantite = $request->request->get('quantite', 0);
        $prix = $request->request->get('prix', 0.0);
        $formSubmitted = false;

        if ($request->isMethod('POST')) {
            $formSubmitted = true;
            // Ici, vous pouvez traiter les informations envoyées et effectuer des opérations en base de données

            // Exemple de traitement : affichage des valeurs dans la console
            dump($nom, $description, $quantite, $prix);
        }

        return $this->render('/pages/gest_item/index.html.twig', [
            'nom' => $nom,
            'description' => $description,
            'quantite' => $quantite,
            'prix' => $prix,
            'formSubmitted' => $formSubmitted,
        ]);
    }
}

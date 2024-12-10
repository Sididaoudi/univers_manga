<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\MangaRepository;

class MustReadMangaController extends AbstractController
{
    // Cette route permet d'afficher les mangas dans la section "Les incontournables"
    #[Route('/mustreadmanga', name: 'mustread')]
    public function mustReadManga(MangaRepository $repository): Response
    {
        // Liste des IDs des mangas incontournables

        
        $idsArray = [3, 4, 5]; // Liste d'IDs des mangas incontournables
        $mustReadMangas = $repository->getMustReadMangaById($idsArray);  // La méthode qui récupère ces mangas

        // Récupérer tous les mangas pour la section "Nouveautés" (ou autres sections)
        $mangas = $repository->findAll();

        // Vérification et envoi des mangas à la vue
        return $this->render('home/index.html.twig', [
            'mustReadMangas' => $mustReadMangas,  // Passe les mangas incontournables à la vue
            'mangas' => $mangas                  // Passe les mangas pour les nouveautés à la vue
        ]);
    }
}
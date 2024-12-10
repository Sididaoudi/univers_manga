<?php

namespace App\Controller;

use App\Repository\MangakaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\MangaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class MangaController extends AbstractController
{
    // Cette route permet d'afficher les mangas par genres
    #[Route('/genres', name: 'genres')]
    public function allMangaByGenre(MangaRepository $repository, Request $request): Response
    {
        // Récupère tous les genres 
        $genres = $repository->getAllGenres();

        // Récupère le genre par défaut 
        $genre = $request->query->get('genre', 'Action');  // 'Action' sera le genre par défaut si aucun genre n'est spécifié dans l'URL


        $mangas = $repository->findByGenre($genre); // permet d'afficher les mangas par genres

        return $this->render('genre/index.html.twig', [
            'mangas' => $mangas,
            'genres' => $genres
        ]);
    }

}

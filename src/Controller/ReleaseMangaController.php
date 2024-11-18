<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\MangaRepository;


class ReleaseMangaController extends AbstractController
{
    // Cette route permet de récupérer tous les mangas puis de les afficher dans la vue dédiée
    #[Route('/planning', name: 'planning')]
    public function allMangaRelease(MangaRepository $repository): Response
    {
        //Permet d'afficher les mangas qui sortent durant le mois
        $startOfTheMonth = new \DateTime('first day of this month');
        $endOfTheMonth = new \DateTime('last day of this month');

        // Récupérer les mangas pour le mois en cours
        $startOfTheMonth = $repository->findByMonth($startOfTheMonth, $endOfTheMonth);

        return $this->render('release_manga/index.html.twig', [
            'mangas' => $startOfTheMonth
        ]);
    }
}

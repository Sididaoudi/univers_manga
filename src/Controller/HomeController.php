<?php

namespace App\Controller;

use App\Repository\MangakaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\MangaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(MangaRepository $repository): Response
    {
        // calculer le début et la fin de la semaine courante
        $startOfWeek = (new \DateTime())->modify('monday this week');
        $endOfWeek = (new \DateTime())->modify('sunday this week');

        // Récupérer les mangas sortis cette semaine
        $mangas = $repository->getMangaByReleaseDate($startOfWeek, $endOfWeek);

        //Permet d'afficher un manga dans la section évènement pendant un mois
        // $startOfTheMonth = new \DateTime('first day of this month');
        // $endOfTheMonth = new \DateTime('last day of this month');

        // Récupérer le(s) manga(s) pour l'événement du mois
        // $eventMangas = $repository->getMangaEvent($startOfTheMonth, $endOfTheMonth);

        // $mangas = $repository->findAll(); 
        return $this->render('home/index.html.twig', [
            'mangas' => $mangas,
            // 'eventMangas' => $eventMangas
        ]);
    }

    // Cette route permet de récupérer tous les mangas puis de les afficher dans la vue dédiée
    #[Route('/allmanga', name: 'all_manga')]
    public function allManga(MangaRepository $repository): Response
    {
        $mangas = $repository->getMangaByAlphabeticalOrder(); // permet de trouver tous les mangas présent en BDD et les afficher par ordre alphabétique

        return $this->render('manga/index.html.twig', [
            'mangas' => $mangas
        ]);
    }

    // Cette route permet de récupérer un manga grâce à son ID puis de voir les informations sur ce dernier
    #[Route('/manga/{id}', name: 'manga.show')]
    public function showManga(MangaRepository $repository, EntityManagerInterface $entityManager, int $id): Response
    {
        $manga = $repository->find($id); // permet de trouver un manga à l'aide de son id

        if (!$manga) {
            throw $this->createNotFoundException(
                'Manga non trouvé' . $id
            );
        }

        return $this->render('manga/show.html.twig', [
            'manga' => $manga
        ]);
    }

    // Cette route permet de récupérer tous les manga-ka puis de les afficher dans la vue dédiée
    #[Route('/allmangaka', name: 'all_mangaka')]
    public function allMangaka(MangakaRepository $repository): Response
    {
        $mangakas = $repository->findAll(); //permet de trouver tous les manga-ka puis de les afficher 

        return $this->render('mangaka/index.html.twig', [
            'mangakas' => $mangakas
        ]);
    }

    // Cette route permet de faire une recherche pour un manga
    #[Route('/research', name: 'research')]
    public function research(MangaRepository $repository, Request $request): Response
    {
        // $manga = $repository->findOneBy(['title' => '']);
        $term = $request->query->get('term');

        $results = $repository->findByTerm($term); 

        
        return $this->render('results/index.html.twig', [
            'results' => $results
        ]);
    }

}

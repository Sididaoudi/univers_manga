<?php

namespace App\Controller;

use App\Repository\MangaRepository;
use App\Repository\MangakaRepository;
use App\Repository\GenreRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;



class APIController extends AbstractController
{
    #[Route('/api/mangas', name: 'api_mangas', methods: ['GET'])]
    public function index(MangaRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        // Calculer le début et la fin de la semaine courante
        $startOfWeek = (new \DateTime())->modify('monday this week');
        $endOfWeek = (new \DateTime())->modify('sunday this week');

        // Récupérer les mangas sortis cette semaine
        $mangas = $repository->getMangaByReleaseDate($startOfWeek, $endOfWeek);

        // Sérialisation avec les groupes de sérialisation
        $data = $serializer->normalize($mangas, null, ['groups' => 'manga:read']);
        
        
        // Ajouter l'URL pour chaque manga
        foreach ($data as &$manga) {
            if (isset($manga['thumbnail'])) {
                // Générer l'URL complète de l'image
                $manga['thumbnail'] = '/images/manga/' . $manga['thumbnail'];

            }
            $manga['link'] = $this->generateUrl('manga.show', ['id' => $manga['id']]);
        }

        // Retourner une réponse JSON avec les mangas et leurs liens
        return new JsonResponse(['mangas' => $data]);
    }

    #[Route('/api/allmanga', name: 'api_allmanga', methods: ['GET'])]
    public function allManga(MangaRepository $repository, SerializerInterface $serializer, Request $request): JsonResponse
    {
        // permet de trouver tous les mangas présent en BDD et les afficher par ordre alphabétique
        $mangas = $repository->getMangaByAlphabeticalOrder();

        // Sérialisation avec les groupes de sérialisation
        $data = $serializer->normalize($mangas, null, ['groups' => 'manga:read']);

        // Récupère tous les genres 
        // $genres = $repository->getAllGenres();

        // Récupère le genre depuis la requête, avec "Action" comme valeur par défaut
        // $genre = $request->query->get('genre', 'Action');

        // $mangas = $repository->findByGenre($genre); 

        // Ajouter l'URL pour chaque manga
        foreach ($data as &$manga) {
            if (isset($manga['thumbnail'])) {
                // Générer l'URL complète de l'image
                $manga['thumbnail'] = '/images/manga/' . $manga['thumbnail'];
            }
            $manga['link'] = $this->generateUrl('manga.show', ['id' => $manga['id']]);
            // $genre['link'] = $this->generateUrl('manga.show', ['id' => $manga['id']]);
        }

        // Retourner une réponse JSON avec les mangas et leurs liens
        return new JsonResponse(['mangas' => $data]);
    }

    // Cette route permet de récupérer un manga grâce à son ID puis de voir les informations sur ce dernier
    #[Route('/api/manga/{id}', name: 'api_manga.show', methods: ['GET'])]
    public function showManga(MangaRepository $repository,  int $id,SerializerInterface $serializer): JsonResponse
    {
        $manga = $repository->find($id); // permet de trouver un manga à l'aide de son id

        // Sérialisation avec les groupes de sérialisation
        $data = $serializer->normalize($manga, null, ['groups' => 'manga:read']);

        // Retourner une réponse JSON avec le manga et son lien
        return new JsonResponse(['manga' => $data]);
    }


    // Cette route permet de récupérer un mangaka grâce à son ID puis de voir les informations sur ce dernier
    #[Route('/api/mangaka/{id}', name: 'api_mangaka.show', methods: ['GET'])]
    public function showMangaka(MangakaRepository $repository,  int $id, SerializerInterface $serializer): JsonResponse
    {
        $mangaka = $repository->find($id); // permet de trouver un manga à l'aide de son id

        // Sérialisation avec les groupes de sérialisation
        $data = $serializer->normalize($mangaka, null, ['groups' => 'manga:read']);

        // Retourner une réponse JSON avec le manga et son lien
        return new JsonResponse(['mangaka' => $data]);
    }


    // Cette route permet de récupérer les genres de manga disponible dans la BDD
    #[Route('/api/genres', name: 'api_allgenres', methods: ['GET'])]
    public function allGenres(GenreRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $genre = $repository->getGenresByAlphabeticalOrder(); // permet de récupèrer tous les genres de manga

        // Sérialisation avec les groupes de sérialisation
        $data = $serializer->normalize($genre, null, ['groups' => 'manga:read']);

        // Retourner une réponse JSON avec le manga et son lien
        return new JsonResponse(['genre' => $data]);
    }

    // Cette route permet de récupérer et afficher toutes les sorties du mois
    #[Route('/api/release', name: 'api_release', methods: ['GET'])]
    public function allRelease(MangaRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        //Permet d'afficher les mangas qui sortent durant le mois
        $startOfTheMonth = new \DateTime('first day of this month');
        $endOfTheMonth = new \DateTime('last day of this month');

        // Récupérer les mangas pour le mois en cours
        $startOfTheMonth = $repository->findByMonth($startOfTheMonth, $endOfTheMonth);

        // Sérialisation avec les groupes de sérialisation
        $data = $serializer->normalize($startOfTheMonth, null, ['groups' => 'manga:read']);

        // Retourner une réponse JSON avec le manga et son lien
        return new JsonResponse(['mangas' => $data]);
    }



    // Cette route permet de récupérer un type de mangaka selon son ID
    #[Route('/api/type/{id}', name: 'api_type', methods: ['GET'])]
    public function type(GenreRepository $repository, SerializerInterface $serializer, int $id): JsonResponse
    {
        $type = $repository->find($id); // permet de récupèrer tous les types de manga

        // Sérialisation avec les groupes de sérialisation
        $data = $serializer->normalize($type, null, ['groups' => 'manga:read']);

        // Retourner une réponse JSON avec le manga et son lien
        return new JsonResponse(['type' => $data]);
    }
    
    
    // Cette route permet de faire une recherche pour un manga
    #[Route('/api/search', name: 'api_research')]
    public function research(MangaRepository $repository, Request $request): JsonResponse
    {
        // $manga = $repository->findOneBy(['title' => '']);
        $term = $request->query->get('term');

        $results = $repository->findByTerm($term);

        if (!$results) {
            error_log("Aucun résultat pour le terme : " . $term);
        }


        return $this->json(['results' => $results], 200, [], ['groups' => 'manga:read']);
    }

}
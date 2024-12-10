<?php

namespace App\Repository;

use App\Entity\Manga;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Manga>
 */
class MangaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Manga::class);
    }

    //    /**
    //     * @return Manga[] Returns an array of Manga objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    // cette fonction permet d'afficher les mangas de la semaine
    public function getMangaByReleaseDate(\DateTime $startOfWeek, \DateTime $endOfWeek)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.release_date BETWEEN :start AND :end')
            ->setParameter('start', $startOfWeek)
            ->setParameter('end', $endOfWeek)
            ->orderBy('m.release_date', 'ASC')
            ->setMaxResults(4) // limite le nombre de manga afficher dans la section "sortie de la semaine"
            ->getQuery()
            ->getResult();
    }

    // cette fonction permet d'afficher les mangas par ordre alphabétique
    public function getMangaByAlphabeticalOrder()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.title', 'ASC')
            ->andWhere('m.title LIKE :title')
            ->orWhere('m.title LIKE :title2')
            ->orWhere('m.title LIKE :title3 ')
            ->setParameter('title', '%Tome 01%') // affiche uniquement les premiers tomes
            ->setParameter('title2', '%Intégrale%') 
            ->setParameter('title3', '%volume%')
            ->getQuery()
            ->getResult();
    }

    // cette fonction permet de faire une recherche
    public function findByTerm(string $term): array 
    {
        return $this->createQueryBuilder('m')
            ->where('m.title LIKE :term')
            ->setParameter('term', '%' . $term . '%')
            ->getQuery()
            ->getResult();
    }

    // cette fonction permet d'afficher les futures sorties 
    public function findByMonth(\DateTime $startOfMonth, \DateTime $endOfMonth): array
    {
        return $this->createQueryBuilder('r')
            ->where('r.release_date BETWEEN :start AND :end')
            ->setParameter('start', $startOfMonth)
            ->setParameter('end', $endOfMonth)
            ->addOrderBy('r.release_date' , 'ASC') // permet d'afficher les sorties par dates
            // ->andWhere('r.title LIKE :title')
            // ->orWhere('r.title LIKE :title2')
            // ->setParameter('title', '%Tome 01%') // affiche uniquement les premiers tomes
            // ->setParameter('title2', '%Intégrale%')
            // ->setParameter('start', $startOfMonth)
            // ->setParameter('end', $endOfWeek)
            // ->setParameter('year', $year)
            ->getQuery()
            ->getResult();
    }

    // cette fonction permet de récupérer tous les genres présent en BDD
    public function getAllGenres()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('g.name', 'ASC')
            ->select('g.name')
            ->join('m.genre', 'g') // lien entre Manga et Genre
            ->groupBy('g.id') // Pour éviter les doublons
            ->getQuery()
            ->getResult();
    }


    // cette fonction permet de récupérer tous les genres présent en BDD
    public function getAllTypes()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('t.name', 'ASC')
            ->select('t.name')
            ->join('m.types', 'g') // lien entre Manga et Types
            ->groupBy('t.id') // Pour éviter les doublons
            ->getQuery()
            ->getResult();
    }

    // cette fonction permet d'afficher les mangas par genre
    public function findByGenre($genre)
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.title', 'ASC')
            ->join('m.genre', 'g') // permet de faire le lien entre les tables genre et manga
            ->where('g.name = :genre')
            ->setParameter('genre', $genre) // permet de définir la valeur :genre
            ->getQuery()
            ->getResult();
    }

    // cette fonction permet d'afficher les mangas dans la section "les incontournables" sélectionner selon leurs ID
    public function getMustReadMangaById(array $ids): array
    {
        return $this->createQueryBuilder('m')
            ->where('m.id IN (:ids)')
            ->setParameter('ids', $ids)
            ->orderBy('m.title', 'ASC')
            ->getQuery()
            ->getResult();
    }


        // cette fonction permet d'afficher les mangas populaires d'après la BDD
    // public function getPopularMangas(): array
    // {
    //     return $this->createQueryBuilder('m')
    //         ->where('m.isPopular = :popular')
    //         ->setParameter('popular', true)
    //         ->setMaxResults(4)
    //         ->getQuery()
    //         ->getResult();
    // }


    //    public function findOneBySomeField($value): ?Manga
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

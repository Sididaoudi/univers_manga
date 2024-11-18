<?php

namespace App\Repository;

use App\Entity\Manga;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
            ->setParameter('title', '%Tome 01%') // affiche uniquement les premiers tomes
            ->setParameter('title2', '%Intégrale%') 
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

    // cette fonction permet d'afficher les futures sorties en fonction des mois
    public function findByMonth(\DateTime $startOfMonth, \DateTime $endOfMonth): array
    {
        return $this->createQueryBuilder('r')
            ->Where('r.release_date BETWEEN :start AND :end')
            ->setParameter('start', $startOfMonth)
            ->setParameter('end', $endOfMonth)
            ->andWhere('r.title LIKE :title')
            ->orWhere('r.title LIKE :title2')
            ->setParameter('title', '%Tome 01%') // affiche uniquement les premiers tomes
            ->setParameter('title2', '%Intégrale%')
            // ->setParameter('start', $startOfMonth)
            // ->setParameter('end', $endOfWeek)
            // ->setParameter('year', $year)
            ->getQuery()
            ->getResult();
    }


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

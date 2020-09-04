<?php

namespace App\Repository;

use App\Entity\ArtistsBioLanguage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ArtistsBioLanguage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArtistsBioLanguage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArtistsBioLanguage[]    findAll()
 * @method ArtistsBioLanguage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtistsBioLanguageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArtistsBioLanguage::class);
    }

    // /**
    //  * @return ArtistsBioLanguage[] Returns an array of ArtistsBioLanguage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ArtistsBioLanguage
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

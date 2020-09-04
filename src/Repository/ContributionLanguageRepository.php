<?php

namespace App\Repository;

use App\Entity\ContributionLanguage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContributionLanguage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContributionLanguage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContributionLanguage[]    findAll()
 * @method ContributionLanguage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContributionLanguageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContributionLanguage::class);
    }

    // /**
    //  * @return ContributionLanguage[] Returns an array of ContributionLanguage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ContributionLanguage
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

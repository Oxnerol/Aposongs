<?php

namespace App\Repository;

use App\Entity\NewContribution;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NewContribution|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewContribution|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewContribution[]    findAll()
 * @method NewContribution[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewContributionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewContribution::class);
    }

    // /**
    //  * @return NewContribution[] Returns an array of NewContribution objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NewContribution
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

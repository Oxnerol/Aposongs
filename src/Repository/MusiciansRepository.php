<?php

namespace App\Repository;

use App\Entity\Musicians;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Musicians|null find($id, $lockMode = null, $lockVersion = null)
 * @method Musicians|null findOneBy(array $criteria, array $orderBy = null)
 * @method Musicians[]    findAll()
 * @method Musicians[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MusiciansRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Musicians::class);
    }

    public function findByLikeMusicianFirstName($search){

        $query = $this->getEntityManager()
        ->createQuery('SELECT musi FROM App\Entity\Musicians musi WHERE musi.firstName LIKE :search ORDER BY musi.firstName')
        ->setParameter('search', '%'.$search.'%');

        return $query->getResult();
    }

    public function findByLikeMusicianLastName($search){

        $query = $this->getEntityManager()
        ->createQuery('SELECT musi FROM App\Entity\Musicians musi WHERE musi.lastName LIKE :search ORDER BY musi.firstName')
        ->setParameter('search', '%'.$search.'%');

        /* return $query->getResult(Query::HYDRATE_ARRAY); */

        return $query->getResult();
    }

    public function findByLikeMusicianNickname($search){

        $query = $this->getEntityManager()
        ->createQuery('SELECT musi FROM App\Entity\Musicians musi WHERE musi.nickname LIKE :search ORDER BY musi.firstName')
        ->setParameter('search', '%'.$search.'%');

        /* return $query->getResult(Query::HYDRATE_ARRAY); */

        return $query->getResult();
    }

    // /**
    //  * @return Musicians[] Returns an array of Musicians objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Musicians
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

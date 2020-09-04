<?php

namespace App\Repository;

use App\Entity\Disc;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Disc|null find($id, $lockMode = null, $lockVersion = null)
 * @method Disc|null findOneBy(array $criteria, array $orderBy = null)
 * @method Disc[]    findAll()
 * @method Disc[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiscRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Disc::class);
    }

    public function findOneRandomDisc(){

        $rawSql = "SELECT d.* FROM disc d ORDER BY RAND() limit 1";

        $rsm = new ResultSetMappingBuilder($this->getEntityManager());
        $rsm->addEntityResult(Disc::class, "d");

        foreach ($this->getClassMetadata()->fieldMappings as $obj) {
            $rsm->addFieldResult("d", $obj["columnName"], $obj["fieldName"]);
        }

        $stmt = $this->getEntityManager()->createNativeQuery($rawSql, $rsm);

        $stmt->execute();

        return $stmt->getResult()[0];

    }
    
    public function getDiscByArtistId ($id)
    {
        
        $query = $this->getEntityManager()
            ->createQuery('SELECT disc, artist FROM App\Entity\Disc disc 
                            JOIN disc.artists artist
                            WHERE artist.id = :id')
                            ->setParameter('id', $id);

        return $query->getResult();
    }

    public function findByLikeDisc($search){

        $query = $this->getEntityManager()
        ->createQuery('SELECT disc FROM App\Entity\Disc disc WHERE disc.name LIKE :search ORDER BY disc.name')
        ->setParameter('search', '%'.$search.'%');

        /* return $query->getResult(Query::HYDRATE_ARRAY); */

        return $query->getResult();
    }

    // /**
    //  * @return Disc[] Returns an array of Disc objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Disc
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

<?php

namespace App\Repository;

use App\Entity\Artists;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Artists|null find($id, $lockMode = null, $lockVersion = null)
 * @method Artists|null findOneBy(array $criteria, array $orderBy = null)
 * @method Artists[]    findAll()
 * @method Artists[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtistsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artists::class);
    }

    public function findOneRandomArtist(){

        $rawSql = "SELECT a.* FROM artists a ORDER BY RAND() limit 1";

        $rsm = new ResultSetMappingBuilder($this->getEntityManager());
        $rsm->addEntityResult(Artists::class, "a");

        foreach ($this->getClassMetadata()->fieldMappings as $obj) {
            $rsm->addFieldResult("a", $obj["columnName"], $obj["fieldName"]);
        }

        $stmt = $this->getEntityManager()->createNativeQuery($rawSql, $rsm);

        $stmt->execute();

        return $stmt->getResult()[0];

    }

    public function findByLikeArtist($search){

        $query = $this->getEntityManager()
        ->createQuery('SELECT artists FROM App\Entity\Artists artists WHERE artists.name LIKE :search ORDER BY artists.name')
        ->setParameter('search', '%'.$search.'%');

        /* return $query->getResult(Query::HYDRATE_ARRAY); */

        return $query->getResult();
    }

    // /**
    //  * @return Artists[] Returns an array of Artists objects
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
    public function findOneBySomeField($value): ?Artists
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

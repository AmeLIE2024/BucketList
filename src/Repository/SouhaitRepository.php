<?php

namespace App\Repository;

use App\Entity\Souhait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Souhait>
 */
class SouhaitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Souhait::class);
    }

    /**Trouve la liste des 5 derniers souhaits
     * @return array
     */
    public function findLastSouhaits():array{
        //en DQL
 //       $entityManager = $this->getEntityManager();
 //       $dql = "SELECT s
 //               FROM App\Entity\Souhait s
 //               ORDER BY s.createdAt DESC";
 //       $query = $entityManager->createQuery($dql);
 //       $query->setMaxResults(5);
 //       return $query->getResult();

        //version QueryBuilder
        $queryBuilder = $this->createQueryBuilder('s')
        ->addOrderBy('s.createdAt', 'DESC')
        ->setMaxResults(5);
        $query = $queryBuilder->getQuery();
        return $query->getResult();

    }


//    /**
//     * @return Souhait[] Returns an array of Souhait objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Souhait
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

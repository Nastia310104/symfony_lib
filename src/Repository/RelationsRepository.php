<?php

namespace App\Repository;

use App\Entity\Relations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Relations|null find($id, $lockMode = null, $lockVersion = null)
 * @method Relations|null findOneBy(array $criteria, array $orderBy = null)
 * @method Relations[]    findAll()
 * @method Relations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RelationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Relations::class);
    }

    // /**
    //  * @return Relations[] Returns an array of Relations objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Relations
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

<?php

namespace App\Repository;

use App\Entity\Books;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Books|null find($id, $lockMode = null, $lockVersion = null)
 * @method Books|null findOneBy(array $criteria, array $orderBy = null)
 * @method Books[]    findAll()
 * @method Books[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BooksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Books::class);
    }

//     /**
//      * @return Books[] Returns an array of Books objects
//      */
//    public function findByFilterAndOrderBy($filter_name, $filter_data, $order_by)
//    {
//        return $this->createQueryBuilder('b')
////            ->andWhere('b.exampleField = :val')
////            ->setParameter('val', $value)
////            ->orderBy('b.id', 'ASC')
////            ->setMaxResults(10)
//            ->andWhere('b.:filter_name = :filter_data')
//            ->orderBy('q.:filter_name', ':order_by')
//            ->setParameter('filter_data', $filter_data)
//            ->setParameter('filter_name', $filter_name)
//            ->setParameter('order_by', $order_by)
//            ->getQuery()
//            ->getResult()
//        ;
//    }


    /**
     * @return Books[] Returns an array of Books objects
     */
    public function findByYearAndDESC($filter_data)
    {
        return $this->createQueryBuilder('b')

            ->andWhere('b.year = :filter_data')
            ->orderBy('b.year', 'DESC')
            ->setParameter('filter_data', $filter_data)
            ->getQuery()
            ->getResult()
            ;
    }


    /*
    public function findOneBySomeField($value): ?Books
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

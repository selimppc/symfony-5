<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\Sales;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sales|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sales|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sales[]    findAll()
 * @method Sales[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sales::class);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getProductByPrevSales($value){
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return mixed
     */
    public function getSoldItem()
    {
        return $this->createQueryBuilder('s')
            ->select('SUM(s.order_qty) as order_qty, s.batch_sequence')
            ->groupBy('s.batch_sequence')
            ->getQuery()
            ->getResult()
            ;
    }


    public function profitAnalyze(){
        return $this->createQueryBuilder('s')
            ->select('SUM(s.order_qty * (s.sell_price - s.cost_price)) as profit')
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }



}

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


    /**
     * @return mixed
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function profitAnalyze(){
        return $this->createQueryBuilder('s')
            ->select('SUM(s.order_qty * (s.sell_price - s.cost_price)) as profit')
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }



}

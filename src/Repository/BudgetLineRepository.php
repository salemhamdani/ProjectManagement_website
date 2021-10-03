<?php

namespace App\Repository;

use App\Entity\BudgetLine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BudgetLine|null find($id, $lockMode = null, $lockVersion = null)
 * @method BudgetLine|null findOneBy(array $criteria, array $orderBy = null)
 * @method BudgetLine[]    findAll()
 * @method BudgetLine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BudgetLineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BudgetLine::class);
    }

    // /**
    //  * @return BudgetLine[] Returns an array of BudgetLine objects
    //  */

    public function findByProjectField($project)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.project = :val')
            ->setParameter('val', $project)
            ;
    }
    /*
    public function findOneBySomeField($value): ?BudgetLine
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

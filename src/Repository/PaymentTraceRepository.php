<?php

namespace App\Repository;

use App\Entity\PaymentTrace;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PaymentTrace|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaymentTrace|null findOneBy(array $criteria, array $orderBy = null)
 * @method PaymentTrace[]    findAll()
 * @method PaymentTrace[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaymentTraceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaymentTrace::class);
    }

    // /**
    //  * @return PaymentTrace[] Returns an array of PaymentTrace objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PaymentTrace
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

<?php

namespace App\Repository;

use App\Entity\PaymentTranche;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PaymentTranche|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaymentTranche|null findOneBy(array $criteria, array $orderBy = null)
 * @method PaymentTranche[]    findAll()
 * @method PaymentTranche[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaymentTrancheRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaymentTranche::class);
    }

    // /**
    //  * @return PaymentTranche[] Returns an array of PaymentTranche objects
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
    public function findOneBySomeField($value): ?PaymentTranche
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

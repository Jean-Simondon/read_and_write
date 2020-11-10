<?php

namespace App\Repository;

use App\Entity\Manuscrit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Manuscrit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Manuscrit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Manuscrit[]    findAll()
 * @method Manuscrit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ManuscritRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Manuscrit::class);
    }

    // /**
    //  * @return Manuscrit[] Returns an array of Manuscrit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Manuscrit
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

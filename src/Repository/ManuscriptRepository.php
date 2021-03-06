<?php

namespace App\Repository;

use App\Entity\Manuscript;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Manuscript|null find($id, $lockMode = null, $lockVersion = null)
 * @method Manuscript|null findOneBy(array $criteria, array $orderBy = null)
 * @method Manuscript[]    findAll()
 * @method Manuscript[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ManuscriptRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Manuscript::class);
    }

    // /**
    //  * @return Manuscript[] Renvoie les manuscrit d'un Utilisateur, trié par nom d'auteur et date de création
    //  */
    // public function findOrderedByAuthorAndCreateDate($userId)
    // {
    //     $result = $this->createQueryBuilder('m')
    //         ->andWhere('m.author.user.id = ' . $userId)
    //         ->orderBy('m.author', 'ASC')
    //         ->getQuery()
    //         ->getResult();

    //     dump($result);
    //     die();

    //     return null;
    // }


    /**
    * @return Manuscript[] Returns an array of Manuscript objects
    */
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

    public function findOneBySomeField($value): ?Manuscript
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

}

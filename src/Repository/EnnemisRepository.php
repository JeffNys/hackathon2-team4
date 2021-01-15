<?php

namespace App\Repository;

use App\Entity\Ennemis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ennemis|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ennemis|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ennemis[]    findAll()
 * @method Ennemis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnnemisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ennemis::class);
    }

    // /**
    //  * @return Ennemis[] Returns an array of Ennemis objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ennemis
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

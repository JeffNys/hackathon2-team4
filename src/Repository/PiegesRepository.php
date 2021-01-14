<?php

namespace App\Repository;

use App\Entity\Pieges;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Pieges|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pieges|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pieges[]    findAll()
 * @method Pieges[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PiegesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pieges::class);
    }

    // /**
    //  * @return Pieges[] Returns an array of Pieges objects
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
    public function findOneBySomeField($value): ?Pieges
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

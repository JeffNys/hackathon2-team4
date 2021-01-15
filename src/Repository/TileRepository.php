<?php

namespace App\Repository;

use App\Entity\Tile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tile|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tile|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tile[]    findAll()
 * @method Tile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tile::class);
    }

    public function removeAll(): void
    {
        $this->createQueryBuilder('t')
            ->update()
            ->set('t.hasObject', ':false')
            ->setParameter('false', false)
            ->set('t.objet', ':null')
            ->setParameter('null', null)
            ->set('t.hasArmes', ':false')
            ->setParameter('false', false)
            ->set('t.arme', ':null')
            ->setParameter('null', null)
            ->set('t.hasPieges', ':false')
            ->setParameter('false', false)
            ->set('t.piege', ':null')
            ->setParameter('null', null)
            ->set('t.hasEnnemy', ':false')
            ->setParameter('false', false)
            ->getQuery()
            ->execute();
    }

}

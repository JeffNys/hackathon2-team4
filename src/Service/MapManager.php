<?php


namespace App\Service;


use App\Entity\Boat;
use App\Repository\BoatRepository;
use App\Repository\TileRepository;
use Doctrine\ORM\EntityManagerInterface;

class MapManager
{
    private $tileRepository;
    private $entityManager;

    public function __construct(TileRepository $tileRepository, EntityManagerInterface $entityManager)
    {
        $this->tileRepository = $tileRepository;
        $this->entityManager = $entityManager;
    }

    public function tileExits(int $x, int $y): bool
    {
        $coordX = [];
        $coordY = [];

        $tiles = $this->tileRepository->findAll();
        foreach( $tiles as $tile)
        {
            $coordX[] = $tile->getCoordX();
            $coordY[] = $tile->getCoordY();
        }
        if(in_array($x, $coordX) && in_array($y, $coordY)) {
            return true;
        }
        return false;
    }

    public function getRandomIsland()
    {
        $tiles = $this->tileRepository->findBy(['type' => 'tuile']);
        foreach($tiles as $tile){
            $tile->setHasTreasure(false);
        }

        $treasureTile = $tiles[array_rand($tiles, 1)]->setHasTreasure(true);
        $this->entityManager->flush();

        return $treasureTile;
    }

    public function placeObjet()
    {
        $tuiles = $this->tileRepository->findAll();
        $suppFirst = array_shift($tuiles);

        $objetTuile = array_rand($tuiles, 3);
        foreach ( $objetTuile as $objet){
            $tuiles[$objet]->setHasObject(true);
            $this->entityManager->flush();
        }

        return $objetTuile;
    }

/*    public function foundObjects(Perso $perso)
    {
        if($tile = $this->tileRepository->findOneBy(
            ['coordX' => $perso->getCoordX(), 'coordY' => $perso->getCoordY()]
        )){
                return $tile->getHasObject();
            }
        }
        return false;
    }*/

     public function fightEnnemy(Perso $perso)
    {
        if($tile = $this->tileRepository->findOneBy(
            ['coordX' => $perso->getCoordX(), 'coordY' => $perso->getCoordY()]
        )){
            return $tile->getHasEnnemy();
        }
        return false;
    }
}

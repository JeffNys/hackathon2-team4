<?php


namespace App\Service;


use App\Entity\Boat;
use App\Entity\Perso;
use App\Repository\ArmesRepository;
use App\Repository\BoatRepository;
use App\Repository\ObjectsRepository;
use App\Repository\PiegesRepository;
use App\Repository\TileRepository;
use Doctrine\ORM\EntityManagerInterface;

class MapManager
{
    private $tileRepository;
    private $entityManager;
    private $armesRepository;
    private $piegesRepository;
    private $objectsRepository;

    public function __construct(TileRepository $tileRepository,
                                EntityManagerInterface $entityManager,
                                ArmesRepository $armesRepository,
                                PiegesRepository $piegesRepository,
                                ObjectsRepository $objectsRepository)
    {
        $this->tileRepository = $tileRepository;
        $this->entityManager = $entityManager;
        $this->armesRepository = $armesRepository;
        $this->piegesRepository = $piegesRepository;
        $this->objectsRepository = $objectsRepository;
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

    public function placeObjets()
    {
        $tuiles = $this->tileRepository->findAll();
        $suppFirst = array_shift($tuiles);

        $objetTuile = array_rand($tuiles, 71);
        $allObjects = $this->objectsRepository->findAll();

        foreach($objetTuile as $objets){
            $object = array_rand($allObjects, 1);
            $tuiles[$objets]->setHasObject(true)->setObjet($allObjects[$object]);
            $this->entityManager->flush();
        }

        /*$armesTuiles = array_rand($tuiles, 3);
        foreach($armesTuiles as $armes) {
            $tuiles[$armes]->
        }*/


        return $objetTuile;
    }

    public function foundObjects(Perso $perso)
    {
        if($tile = $this->tileRepository->findOneBy(
            ['coordX' => $perso->getCoordonneesX(), 'coordY' => $perso->getCoordonneesY()]
        )){
                return $tile->getHasObject();
            }
        return false;
    }

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

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

    public function placeObjets()
    {
        $tuiles = $this->tileRepository->findAll();
        $suppFirst = array_shift($tuiles);

        $objetTuile = array_rand($tuiles, 4);
        $allObjects = $this->objectsRepository->findAll();

        foreach($objetTuile as $objets){
            $object = array_rand($allObjects, 1);
            $tuiles[$objets]->setHasObject(true)->setObjet($allObjects[$object]);
            $this->entityManager->flush();
        }

        /*$allArmes = $this->armesRepository->findAll();
        $armesTuiles = array_rand($tuiles, 4);
        foreach($armesTuiles as $armes => $key) {
            $arme = array_rand($allArmes, 1);
            $tuiles[$key]->setHasArmes(true)->setArme($allArmes[$arme]);
            $this->entityManager->flush();
        }

        $allPieges = $this->piegesRepository->findAll();
        $piegesTuile = array_rand($tuiles, 4);

        foreach($piegesTuile as $pieges){
            $piege = array_rand($allPieges, 4);
            $tuiles[$pieges]->setHasPieges(true)->setPiege($allPieges[$piege]);
            $this->entityManager->flush();
        }*/
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

    public function foundPiege(Perso $perso)
    {
        if($tile = $this->tileRepository->findOneBy(
            ['coordX' => $perso->getCoordonneesX(), 'coordY' => $perso->getCoordonneesY()]
        )){
                return $tile->getHasPieges();
            }
        return false;
    }

    public function foundArme(Perso $perso)
    {
        if($tile = $this->tileRepository->findOneBy(
            ['coordX' => $perso->getCoordonneesX(), 'coordY' => $perso->getCoordonneesY()]
        )){
                return $tile->getHasArmes();
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

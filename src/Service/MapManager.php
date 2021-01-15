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

        $allObjects = $this->objectsRepository->findAll();

        for ($i = 0; $i < 4; $i++) {
            $objetTuile = array_rand($tuiles, 1);
            $tuiles[$objetTuile]->setHasObject(true)->setObjet($allObjects[$i]);
            $this->entityManager->flush();
        }
    }

    public function placePiege()
    {
        $tuiles = $this->tileRepository->findAll();
        $suppFirst = array_shift($tuiles);

        $allPieges = $this->piegesRepository->findAll();

        for ($i = 0; $i < 4; $i++) {
            $piegeTuile = array_rand($tuiles, 1);
            $tuiles[$piegeTuile]->setHasPieges(true)->setPiege($allPieges[$i]);
            $this->entityManager->flush();
        }
    }

    public function placeArme()
    {
        $tuiles = $this->tileRepository->findAll();
        $suppFirst = array_shift($tuiles);

        $allArmes = $this->armesRepository->findAll();

        for ($i = 0; $i < 4; $i++) {
            $armeTuile = array_rand($tuiles, 1);
            $tuiles[$armeTuile]->setHasArmes(true)->setArme($allArmes[$i]);
            $this->entityManager->flush();
        }
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

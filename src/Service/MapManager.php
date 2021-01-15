<?php


namespace App\Service;


use App\Entity\Perso;
use App\Repository\ArmesRepository;
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

    public function __construct(
        TileRepository $tileRepository,
        EntityManagerInterface $entityManager,
        ArmesRepository $armesRepository,
        PiegesRepository $piegesRepository,
        ObjectsRepository $objectsRepository
    ) {
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
        foreach ($tiles as $tile) {
            $coordX[] = $tile->getCoordX();
            $coordY[] = $tile->getCoordY();
        }
        if (in_array($x, $coordX) && in_array($y, $coordY)) {
            return true;
        }
        return false;
    }

    public function placeObjets()
    {
        $tuiles = $this->tileRepository->findAll();
        array_shift($tuiles);
        $allObjets = $this->objectsRepository->findAll();
        $nombreObjets = 4;
        // donc on selectionne au hasard les objets qu'on veut
        $objetsCommandes = array_rand($allObjets, $nombreObjets);
        // et les tuiles sur lesquels on veut les placer
        $tuileObjets = array_rand($tuiles, $nombreObjets);
        $i = 0;
        foreach ($tuileObjets as $tuileObjet) {
            $tuiles[$tuileObjet]->setHasObject(true)->setObjet($allObjets[$objetsCommandes[$i]]);
            $this->entityManager->persist($tuiles[$tuileObjet]);
            $i++;
        }
        $this->entityManager->flush();
    }

    public function placePiege()
    {
        // on prend toutes les tuiles
        $tuiles = $this->tileRepository->findAll();
        // on supprime la première :-)
        array_shift($tuiles);

        // on selectionne tout les pièges existant
        $allPieges = $this->piegesRepository->findAll();

        $nombre2Pieges = 4;

        // donc on selectionne au hasard les pièges qu'on veut
        $piegesCommandes = array_rand($allPieges, $nombre2Pieges);
        // et les tuiles sur lesquels on veut les placer
        $tuilePiegees = array_rand($tuiles, $nombre2Pieges);

        // et maintenant, on les place
        $i = 0;
        foreach ($tuilePiegees as $tuilePiegee) {
            $tuiles[$tuilePiegee]->setHasPieges(true)->setPiege($allPieges[$piegesCommandes[$i]]);
            $this->entityManager->persist($tuiles[$tuilePiegee]);
            $i++;
        }
        $this->entityManager->flush();
    }

    public function placeArme()
    {
        $tuiles = $this->tileRepository->findAll();
        array_shift($tuiles);
        $allArmes = $this->armesRepository->findAll();
        $nombreArmes = 4;
        // donc on selectionne au hasard les armes qu'on veut
        $armesCommandes = array_rand($allArmes, $nombreArmes);
        // et les tuiles sur lesquels on veut les placer
        $tuileArmees = array_rand($tuiles, $nombreArmes);
        $i = 0;
        foreach ($tuileArmees as $tuileArmee) {
            $tuiles[$tuileArmee]->setHasArmes(true)->setArme($allArmes[$armesCommandes[$i]]);
            $this->entityManager->persist($tuiles[$tuileArmee]);
            $i++;
        }
        $this->entityManager->flush();
    }

    public function foundObjects(Perso $perso)
    {
        if ($tile = $this->tileRepository->findOneBy(
            ['coordX' => $perso->getCoordonneesX(), 'coordY' => $perso->getCoordonneesY()]
        )) {
            return $tile->getHasObject();
        }
        return false;
    }

    public function foundPiege(Perso $perso)
    {
        if ($tile = $this->tileRepository->findOneBy(
            ['coordX' => $perso->getCoordonneesX(), 'coordY' => $perso->getCoordonneesY()]
        )) {
            return $tile->getHasPieges();
        }
        return false;
    }

    public function foundArme(Perso $perso)
    {
        if ($tile = $this->tileRepository->findOneBy(
            ['coordX' => $perso->getCoordonneesX(), 'coordY' => $perso->getCoordonneesY()]
        )) {
            return $tile->getHasArmes();
        }
        return false;
    }

    public function fightEnnemy(Perso $perso)
    {
        if ($tile = $this->tileRepository->findOneBy(
            ['coordX' => $perso->getCoordonneesX(), 'coordY' => $perso->getCoordonneesY()]
        )) {
            return $tile->getHasEnnemy();
        }
        return false;
    }
}

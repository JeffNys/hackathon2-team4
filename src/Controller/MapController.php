<?php

namespace App\Controller;

use App\Entity\Tile;
use App\Service\MapManager;
use App\Repository\BoatRepository;
use App\Repository\TileRepository;
use App\Repository\PersoRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MapController extends AbstractController
{

    /**
     * @Route("/start", name="start")
     */
    public function start(BoatRepository $boatRepository, MapManager $mapManager)
    {
        $boat = $boatRepository->findOneBy([]);
        $boat->setCoordX(0)->setCoordY(0);
        $mapManager->getRandomIsland();

        return $this->redirectToRoute('map');
    }

    /**
     * @Route("/map", name="map")
     */
<<<<<<< HEAD
    public function displayMap(BoatRepository $boatRepository, MapManager $mapManager): Response
=======
    public function displayMap(PersoRepository $persoRepository, TileRepository $tileRepository): Response
>>>>>>> 3cc94c9af28b1e539189f3db70cc3a9820841be0
    {
        $em = $this->getDoctrine()->getManager();
        $tiles = $em->getRepository(Tile::class)->findAll();


        foreach ($tiles as $tile) {
            $map[$tile->getCoordX()][$tile->getCoordY()] = $tile;
        }

        $perso = $persoRepository->findOneBy([]);

        $mapManager->placeObjet();

        return $this->render('map/index.html.twig', [
            'map'  => $map ?? [],
            'perso' => $perso,
        ]);
    }
}

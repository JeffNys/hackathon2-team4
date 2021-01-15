<?php

namespace App\Controller;

use App\Entity\Tile;
use App\Service\MapManager;
use App\Repository\TileRepository;
use App\Repository\PersoRepository;
use App\Services\ApplyEffects;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MapController extends AbstractController
{

    /**
     * @Route("/start", name="start")
     */
    public function start(PersoRepository $persoRepository,
                          MapManager $mapManager,
                          TileRepository $tileRepository,
                          ApplyEffects $effects)
    {
        $tileRepository->removeAll();
        $perso = $persoRepository->findOneBy([]);
        $perso->setCoordonneesX(0)->setCoordonneesY(0);
        $effects->reset($perso);
        $mapManager->placeObjets();
        $mapManager->placeArme();
        $mapManager->placePiege();

        return $this->redirectToRoute('map');
    }

    /**
     * @Route("/map", name="map")
     */
    public function displayMap(PersoRepository $persoRepository, TileRepository $tileRepository, MapManager $mapManager): Response
    {
        $em = $this->getDoctrine()->getManager();
        $tiles = $em->getRepository(Tile::class)->findAll();


        foreach ($tiles as $tile) {
            $map[$tile->getCoordX()][$tile->getCoordY()] = $tile;
        }

        $perso = $persoRepository->findOneBy([]);

        //$mapManager->placeObjets();

        return $this->render('map/index.html.twig', [
            'map'  => $map ?? [],
            'perso' => $perso,
        ]);
    }
}

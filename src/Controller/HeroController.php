<?php

namespace App\Controller;

use App\Repository\HeroRepository;
use App\Services\API;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HeroController extends AbstractController
{
    /**
     * @Route("/hero", name="hero")
     */
    public function index(): Response
    {
        return $this->render('hero/index.html.twig', [
            'controller_name' => 'HeroController',
        ]);
    }

    /**
     * @Route("/majapi", name="hero_api")
     */
    public function api(API $connection): Response
    {
        // pour télécharger les données depuis l'API vers la BDD
        $connection->hydratageBDD();
        return $this->render('hero/api.html.twig');
    }

    /**
     * @Route("/Hero/gentils", name="hero_gentils")
     */
    public function affichageGentils(HeroRepository $heroTable): Response
    {
        $gentils = $heroTable->findBy(['alignment' => 'good']);
        $alphabet = range('A', 'Z');
        return $this->render('hero/gentils.html.twig', [
            'gentils' => $gentils,
            'alphabet' => $alphabet,
        ]);
    }

    /**
     * @Route("/Hero/mechants", name="hero_mechants")
     */
    public function affichageMechants(HeroRepository $heroTable): Response
    {
        $mechants = $heroTable->findBy(['alignment' => 'bad']);
        return $this->render('hero/mechants.html.twig', [
            'mechants' => $mechants
        ]);
    }

    /**
     * @Route("/Hero/{id}/détails", name="hero_details")
     */
    public function voirHero(int $id, HeroRepository $heroTable): Response
    {
        $hero = $heroTable->findOneBy(['id' => $id]);
        return $this->render('hero/details.html.twig', [
            'hero' => $hero
        ]);
    }
}

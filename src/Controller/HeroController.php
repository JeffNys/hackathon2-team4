<?php

namespace App\Controller;

use App\Entity\Perso;
use App\Services\API;
use App\Repository\HeroRepository;
use App\Repository\PersoRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    /**
     * @Route("/Hero/{id}/creation", name="hero_creation")
     */
    public function creation(
        int $id,
        HeroRepository $heroTable,
        PersoRepository $persoTable,
        EntityManagerInterface $em): Response
    {
        // première étape, récupérer le héro brut
        $hero = $heroTable->findOneBy(['id' => $id]);
        // ensuite, il faut "créer un objet" personnage
        // mais avant ça, il faut faire des calculs savant pour déterminer
        // les points de vie, d'attaque etc...
        $pointsAttaque = ($hero->getSpeed() + $hero->getStrength() + $hero->getCombat()) / 3;
        $pointsEsquive = ($hero->getSpeed() + $hero->getIntelligence() + $hero->getCombat()) / 3;
        $pointsDefense = ($hero->getDurability() + $hero->getStrength() + $hero->getPower()) / 3;
        // allez, on crée l'objet
        $perso = new Perso();
        // et ajouter les infos à mettre dedans
        $perso
            ->setNom($hero->getName())
            ->setIntelligence($hero->getIntelligence())
            ->setForceMusculaire($hero->getStrength())
            ->setVitesse($hero->getSpeed())
            ->setEndurance($hero->getDurability())
            ->setPuissance($hero->getPower())
            ->setCombat($hero->getCombat())
            ->setHero($hero)
            ->setVie(100)
            ->setPointsAttaque($pointsAttaque)
            ->setPointsEsquive($pointsEsquive)
            ->setPointsDefense($pointsDefense)
            ->setCoordonneesX(0)
            ->setCoordonneesY(0);
        // afin d'éviter les déconvenu, hop, on vide la table des persos
        // comme ça, il n'y a qu'un seul perso dans la table
        $toutLesPersos = $persoTable->findAll();
        foreach ($toutLesPersos as $persoAncien) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($persoAncien);
        }
        $em->flush();
        // ensuite on a plus qu'a le jeter dans la BDD
        $em->persist($perso);
        $em->flush();
        return $this->redirectToRoute('map');
    }
}

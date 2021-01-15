<?php

namespace App\DataFixtures;

use App\Entity\Armes;
use App\Entity\Hero;
use App\Entity\Perso;
use App\Repository\HeroRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class EnnemisFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $heros = $manager->getRepository(Hero::class)->findAll();
        foreach ($heros as $hero) {
            // ensuite, il faut "créer un objet" personnage
            // mais avant ça, il faut faire des calculs savant pour déterminer
            // les points de vie, d'attaque etc...
            $pointsAttaque = ($hero->getSpeed() + $hero->getStrength() + $hero->getCombat()) / 3;
            $pointsEsquive = ($hero->getSpeed() + $hero->getIntelligence() + $hero->getCombat()) / 3;
            $pointsDefense = ($hero->getDurability() + $hero->getStrength() + $hero->getPower()) / 3;
            $vie = $hero->getDurability() / 2;
            $ennemi = new Perso();
            // et ajouter les infos à mettre dedans
            $ennemi
                ->setNom($hero->getName())
                ->setImage($hero->getImage())
                ->setIntelligence($hero->getIntelligence())
                ->setForceMusculaire($hero->getStrength())
                ->setVitesse($hero->getSpeed())
                ->setEndurance($hero->getDurability())
                ->setPuissance($hero->getPower())
                ->setCombat($hero->getCombat())
                ->setHero($hero)
                ->setVie($vie)
                ->setPointsAttaque($pointsAttaque)
                ->setPointsEsquive($pointsEsquive)
                ->setPointsDefense($pointsDefense);
            $manager->persist($ennemi);
        }
        $manager->flush();
    }
}

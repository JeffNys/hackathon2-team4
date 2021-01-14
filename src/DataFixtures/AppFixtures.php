<?php

/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 23/11/18
 * Time: 11:29
 */

namespace App\DataFixtures;

use App\Entity\Boat;
use App\Entity\Tile;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $tiles = [
            ['tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile'],
            ['tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile'],
            ['tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile'],
            ['tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile'],
            ['tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile'],
            ['tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile', 'tuile'],
        ];

        foreach ($tiles as $y => $line) {
            foreach ($line as $x => $type) {
                $tile = new Tile();
                $tile->setType($type);
                $tile->setCoordX($x);
                $tile->setCoordY($y);
                $tile->setHasEnnemy(false);
                $tile->setHasObject(false);
                $manager->persist($tile);
            }
        }

        $boat = new Boat();
        $boat->setCoordX(0);
        $boat->setCoordY(0);
        $boat->setName('Black Pearl');
        $manager->persist($boat);

        $manager->flush();
    }
}

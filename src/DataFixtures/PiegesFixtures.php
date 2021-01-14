<?php

namespace App\DataFixtures;

use App\Entity\Pieges;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PiegesFixtures extends Fixture
{

    const OBJECT = [
        'Toilette après Yavuz' => [
            'image' => 'https://static.wikia.nocookie.net/minecraft_gamepedia/images/0/05/Poison.png/revision/latest?cb=20190423121059',
            'puissance' => -30,
            'caractéristique' => 'life',
        ],
        'Tacos pas frais' => [
            'image' => 'https://static.wikia.nocookie.net/minecraft_gamepedia/images/a/a3/Nausea.png/revision/20190423121017',
            'puissance' => -30,
            'caractéristique' => 'strength',
        ],
        'Les élèves de Tour' => [
            'image' => 'https://static.wikia.nocookie.net/minecraft_gamepedia/images/2/21/Bad_Omen.png/revision/latest?cb=20190301213537',
            'puissance' => -30,
            'caractéristique' => 'intelligence',
        ],
        'La belle mère' => [
            'image' => 'https://static.wikia.nocookie.net/minecraft_gamepedia/images/7/7e/Slowness.png/revision/latest?cb=20190423121219',
            'puissance' => -30,
            'caractéristique' => 'speed',
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (SELF::OBJECT as $nom => $data) {
            $object = new Pieges();
            $object->setNom($nom);
            $object->setImage($data['image']);
            $object->setPuissance($data['puissance']);
            $object->setCaracteristique($data['caractéristique']);
            $manager->persist($object);
        }
        $manager->flush();
    }
}

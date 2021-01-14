<?php

namespace App\DataFixtures;


use App\Entity\Objects;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ObjectsFixtures extends Fixture
{

    const OBJECT = [
        'Potion de vie' => [
            'image' => 'https://static.wikia.nocookie.net/minecraft_gamepedia/images/3/3e/Potion_of_Healing_JE2_BE2.png/revision/latest?cb=20191027040649',
            'puissance' => 40,
            'caractéristique' => 'life',
        ],
        'Potion de force' => [
            'image' => 'https://static.wikia.nocookie.net/minecraft_gamepedia/images/2/2f/Potion_of_Fire_Resistance_JE1_BE1.png/revision/latest?cb=20191027042017',
            'puissance' => 30,
            'caractéristique' => 'strength',
        ],
        'Potion d\'endurance' => [
            'image' => 'https://static.wikia.nocookie.net/minecraft_gamepedia/images/0/06/Potion_of_Regeneration_JE2_BE2.png/revision/latest?cb=20191027040819',
            'puissance' => 30,
            'caractéristique' => 'durability',
        ],
        'Potion de vitesse' => [
            'image' => 'https://static.wikia.nocookie.net/minecraft_gamepedia/images/2/22/Potion_of_Leaping_JE1_BE1.png/revision/latest?cb=20200108004444',
            'puissance' => 30,
            'caractéristique' => 'speed',
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (SELF::OBJECT as $nom => $data) {
            $object = new Objects();
            $object->setNom($nom);
            $object->setImage($data['image']);
            $object->setPuissance($data['puissance']);
            $object->setCaracteristique($data['caractéristique']);
            $manager->persist($object);
        }
        $manager->flush();
    }
}

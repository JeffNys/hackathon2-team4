<?php

namespace App\DataFixtures;

use App\Entity\Armes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArmesFixtures extends Fixture
{

    const OBJECT = [
        'Epée d\'Odin' => [
            'image' => 'https://images-na.ssl-images-amazon.com/images/I/81%2BeR2h-gqL._AC_SL1500_.jpg',
            'puissance' => 40,
            'caractéristique' => 'pointsAttaque',
        ],
        'Marteau de Thor' => [
            'image' => 'https://www.closeupshop.fr/media/oart_0/oart_m/oart_89734/thumbs/908344_2487441.jpg',
            'puissance' => 15,
            'caractéristique' => 'pointsAttaque',
        ],
        'Bouclier de Captain America' => [
            'image' => 'https://images-na.ssl-images-amazon.com/images/I/610Gi9cLjtL._AC_SL1500_.jpg',
            'puissance' => 20,
            'caractéristique' => 'pointsDefense',
        ],
        'Gant en cuir' => [
            'image' => 'https://static.wikia.nocookie.net/minecraft_gamepedia/images/2/22/Potion_of_Leaping_JE1_BE1.png/revision/latest?cb=20200108004444',
            'puissance' => 2,
            'caractéristique' => 'pointsDefense',
        ],
        'Bouclier standard' => [
            'image' => 'https://static.wikia.nocookie.net/minecraft_gamepedia/images/2/22/Potion_of_Leaping_JE1_BE1.png/revision/latest?cb=20200108004444',
            'puissance' => 5,
            'caractéristique' => 'pointsDefense',
        ],
        'Pierre de l\'esprit' => [
            'image' => 'https://static.wikia.nocookie.net/marvelstudios/images/3/32/Mind_Stone-Clean.png/revision/latest/scale-to-width-down/280?cb=20160626122900&path-prefix=fr',
            'puissance' => 20,
            'caractéristique' => 'pointsEsquive',
        ],
        'Anneau d\'intuition' => [
            'image' => 'https://static.wikia.nocookie.net/marvelstudios/images/3/32/Mind_Stone-Clean.png/revision/latest/scale-to-width-down/280?cb=20160626122900&path-prefix=fr',
            'puissance' => 10,
            'caractéristique' => 'pointsEsquive',
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (SELF::OBJECT as $nom => $data) {
            $object = new Armes();
            $object->setNom($nom);
            $object->setImage($data['image']);
            $object->setPuissance($data['puissance']);
            $object->setCaracteristique($data['caractéristique']);
            $manager->persist($object);
        }
        $manager->flush();
    }
}

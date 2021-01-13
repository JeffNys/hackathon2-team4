<?php

namespace App\Services;

use App\Entity\Hero;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpClient\HttpClient;

class API
{
    private $em;
    // private $manager;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        // $this->manager = $manager;
    }

    public function hydratageBDD(): void
    {
        $superHeroApi = HttpClient::create();
        $idDansAPI = 0;
        $antiBoucleInfini = 2021;
        $end = false;

        while (!$end) {
            $idDansAPI++;
            $url = "https://www.superheroapi.com/api.php/3595089573919052/$idDansAPI";
            $reponse = $superHeroApi->request('GET', $url);
            $statutCode = $reponse->getStatusCode(); // récuperer le statut code 200
            if ($statutCode === 200) {
                $contenu = $reponse->getContent();
                // récuperer la requette au format JSON

                $contenu = $reponse->toArray();
                // on converti le JSON en un tableau PHP
                // ici on a un tableau avec notre superhero
                // on va d'abord tester si le héro est déjà dans la base
                $heroExistant = $this->em->getRepository(Hero::class)->findOneBy(['id_api' => $idDansAPI]);
                // on va tester si on a suffisament d'infos sur notre héro pour le mettre dans la BDD
                $donneesValide = false;
                if (
                    "error" != $contenu['response'] &&
                    "null" != $idDansAPI &&
                    "null" != $contenu['name'] &&
                    "null" != $contenu['powerstats']['intelligence'] &&
                    "null" != $contenu['powerstats']['strength'] &&
                    "null" != $contenu['powerstats']['speed'] &&
                    "null" != $contenu['powerstats']['durability'] &&
                    "null" != $contenu['powerstats']['power'] &&
                    "null" != $contenu['powerstats']['combat'] &&
                    "null" != $contenu['biography']['publisher'] &&
                    "null" != $contenu['biography']['alignment'] &&
                    "null" != $contenu['appearance']['gender'] &&
                    "null" != $contenu['appearance']['race'] &&
                    "null" != $contenu['appearance']['height'][1] &&
                    "null" != $contenu['appearance']['weight'][1] &&
                    "null" != $contenu['image']['url']
                ) {
                    $donneesValide = true;
                }
                if (!$heroExistant && $donneesValide) {
                    // et s'il n'existe pas encore et que c'est validé, on va créer un héro dans notre base
                    // on commence par créer l'objet de notre héro
                    $hero = new Hero();
                    $hero
                        ->setIdApi($idDansAPI)
                        ->setName($contenu['name'])
                        ->setIntelligence($contenu['powerstats']['intelligence'])
                        ->setStrength($contenu['powerstats']['strength'])
                        ->setSpeed($contenu['powerstats']['speed'])
                        ->setDurability($contenu['powerstats']['durability'])
                        ->setPower($contenu['powerstats']['power'])
                        ->setCombat($contenu['powerstats']['combat'])
                        ->setPublisher($contenu['biography']['publisher'])
                        ->setAlignment($contenu['biography']['alignment'])
                        ->setGender($contenu['appearance']['gender'])
                        ->setRace($contenu['appearance']['race'])
                        ->setHeightCM($contenu['appearance']['height'][1])
                        ->setWeight($contenu['appearance']['weight'][1])
                        ->setImage($contenu['image']['url']);

                    // donc on à créé un objet héro
                    // et on le stock dans doctrine, il faudra penser à flusher à la fin
                    $this->em->persist($hero);
                }
                if ("error" == $contenu['response']) {
                    $end = true;
                }
                dump($idDansAPI);
            }

            // on va aussi se prémunir contre les boucles infini, petite précaution...
            $antiBoucleInfini--;
            if ($antiBoucleInfini < 0) {
                $end = true;
            }
            // vala
        }
        // bien, ben on envoit tout les héros dans la base de donnée maintenant
        $this->em->flush();
    }
}

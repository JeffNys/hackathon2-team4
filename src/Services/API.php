<?php

namespace App\Services;

use Symfony\Component\HttpClient\HttpClient;

class API
{
    public function hydratageBDD(): void
    {
        $superHeroApi = HttpClient::create();

        $idDansAPI = 1;
        $url = "https://www.superheroapi.com/api.php/3595089573919052/$idDansAPI";
        $reponse = $superHeroApi->request('GET', $url);
        $statutCode = $reponse->getStatusCode(); // récuperer le statut code 200

        if ($statutCode === 200) {
            $contenu = $reponse->getContent();
            // récuperer la requette au format JSON

            $contenu = $reponse->toArray();
            // on converti le JSON en un tableau PHP
        }
        dd($contenu);
    }
}

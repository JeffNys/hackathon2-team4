<?php


namespace App\Services;


class Rencontre
{
    private $joueur;
    private $enemy;

    public function combat(array $personnage)
    {
        $this->joueur = $personnage[0];
        $this->enemy = $personnage[1];
        // qui commence
        if ($this->whoStart($personnage) === $personnage[0]) {
            $attaquant1 = $personnage[0];
            $attaquant2 = $personnage[1];
        } else {
            $attaquant1 = $personnage[1];
            $attaquant2 = $personnage[0];
        }
        // boucle d'attaque
        if ($attaquant1['vie'] > 0 && $attaquant2['vie'] > 0) {
            for($i = 0; $i > 2; $i++) {
                $this->attaque($attaquant1);
                if($attaquant2['vie'] > 0){
                    $this->attaque($attaquant2);
                }
            }
        }
    }

    public function whoStart(array $personnage)
    {
        if ($personnage[0]['vitesse'] === $personnage[1]['vitesse']) {
            $rand = rand(1,2);
            if($rand === 1) {
                return $personnage[0];
            } else {
                return $personnage[1];
            }
        }
        if ($personnage[0]['vitesse'] > $personnage[1]['vitesse']) {
            return $personnage[0];
        }else{
            return $personnage[1];
        }
    }

    public function attaque(array $attaquant)
    {

    }

    public function fuite()
    {

    }

    public function getJoueur()
    {
        return $this->joueur;
    }

    public function getEnemy()
    {
        return $this->enemy;
    }

    public function setJoueur($joueur): void
    {
        $this->joueur = $joueur;
    }

    public function setEnemy($enemy): void
    {
        $this->enemy = $enemy;
    }


}

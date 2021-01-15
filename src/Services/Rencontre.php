<?php


namespace App\Services;


class Rencontre
{
    private $joueur;
    private $enemy;
    private $combat;

    public function combat(array $personnages)
    {
        $this->joueur = $personnages[0];
        $this->enemy = $personnages[1];
        // qui commence
        if ($this->whoStart($personnages) === $personnages[0]) {
            $attaquant1 = $personnages[0];
            $attaquant2 = $personnages[1];
        } else {
            $attaquant1 = $personnages[1];
            $attaquant2 = $personnages[0];
        }
        // boucle d'attaque
        while ($attaquant1['vie'] > 0 && $attaquant2['vie'] > 0) {
            $this->attaque($attaquant1, $attaquant2);
            if ($attaquant2['vie'] > 0) {
                $this->attaque($attaquant2, $attaquant1);
            }
        }
    }

    public function whoStart(array $personnages): array
    {
        if ($personnages[0]['vitesse'] === $personnages[1]['vitesse']) {
            $rand = rand(1, 2);
            if ($rand === 1) {
                return $personnages[0];
            } else {
                return $personnages[1];
            }
        }
        if ($personnages[0]['vitesse'] > $personnages[1]['vitesse']) {
            return $personnages[0];
        } else {
            return $personnages[1];
        }
    }

    private function attaque(array $attaquant, array $defenseur): int
    {
        $vie = $defenseur['vie'];
        // est ce qu'il y a esquive?
        $esquive = $this->esquive($attaquant['pointsAttaque'], $defenseur['pointsEsquive']);
        if (!$esquive) {
            $vie = $vie - $attaquant['pointAttaque'] * (100 - $defenseur['pointsDefense']) / 100;
        }
        return $vie;
    }

    private function esquive(int $pointsAttaque, int $pointEsquive): bool
    {
        $esquive = false;
        $comparatif = $pointEsquive - $pointsAttaque;
        if ($comparatif > 30) {
            $test = 70;
        } elseif ($comparatif > 20) {
            $test = 50;
        } elseif ($comparatif > 10) {
            $test = 30;
        } elseif ($comparatif > 0) {
            $test = 20;
        } elseif ($comparatif > -10) {
            $test = 10;
        } elseif ($comparatif > -20) {
            $test = 20;
        }
        $chanceEsquive = rand(1, 100);
        if ($chanceEsquive < $test) {
            $esquive = true;
        }
        return $esquive;
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

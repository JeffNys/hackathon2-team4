<?php


namespace App\Services;


use App\Entity\Armes;
use App\Entity\Objects;
use App\Entity\Perso;
use App\Entity\Pieges;
use Doctrine\ORM\EntityManagerInterface;

class ApplyEffects
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function applyPotion(Perso $perso, Objects $potion)
    {
        switch ($perso) {
            case ($potion->getCaracteristique() == 'life');
                $perso->setVie($perso->getVie() + $potion->getPuissance());
                $this->entityManager->flush();
                break;
            case ($potion->getCaracteristique() == 'strength');
                $perso->setForceMusculaire($perso->getForceMusculaire() + $potion->getPuissance());
                $this->entityManager->flush();
                break;
            case ($potion->getCaracteristique() == 'durability');
                $perso->setEndurance($perso->getEndurance() + $potion->getPuissance());
                $this->entityManager->flush();
                break;
            case ($potion->getCaracteristique() == 'speed');
                $perso->setVitesse($perso->getVitesse() + $potion->getPuissance());
                $this->entityManager->flush();
                break;
        }
    }

    public function applyPiege(Perso $perso, Pieges $piege)
    {
        switch ($perso) {
            case ($piege->getCaracteristique() == 'life');
                $perso->setVie($perso->getVie() + $piege->getPuissance());
                $this->entityManager->flush();
                break;
            case ($piege->getCaracteristique() == 'strength');
                $perso->setForceMusculaire($perso->getForceMusculaire() + $piege->getPuissance());
                $this->entityManager->flush();
                break;
            case ($piege->getCaracteristique() == 'intelligence');
                $perso->setIntelligence($perso->getIntelligence() + $piege->getPuissance());
                $this->entityManager->flush();
                break;
            case ($piege->getCaracteristique() == 'speed');
                $perso->setVitesse($perso->getVitesse() + $piege->getPuissance());
                $this->entityManager->flush();
                break;
        }
    }

    public function applyArme(Perso $perso, Armes $arme)
    {
        switch ($perso) {
            case ($arme->getCaracteristique() == 'pointsAttaque');
                $perso->setPointsAttaque($perso->getForceMusculaire(), $perso->getVitesse(), $perso->getCombat());
                $this->entityManager->flush();
                break;
            case ($arme->getCaracteristique() == 'pointsDefense');
                $perso->setPointsDefense($perso->getEndurance(), $perso->getForceMusculaire(), $perso->getPuissance());
                $this->entityManager->flush();
                break;
            case ($arme->getCaracteristique() == 'pointsEsquive');
                $perso->setPointsEsquive($perso->getVitesse(), $perso->getIntelligence(), $perso->getCombat());
                $this->entityManager->flush();
                break;
        }
    }

    public function reset(Perso $perso)
    {
        $perso->setIntelligence($perso->getHero()->getIntelligence());
        $perso->setCombat($perso->getHero()->getCombat());
        $perso->setEndurance($perso->getHero()->getDurability());
        $perso->setVitesse($perso->getHero()->getSpeed());
        $perso->setForceMusculaire($perso->getHero()->getStrength());
        $perso->setPuissance($perso->getHero()->getPower());
        $perso->setVie(100);
    }
}

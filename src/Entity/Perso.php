<?php

namespace App\Entity;

use App\Repository\PersoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersoRepository::class)
 */
class Perso
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="integer")
     */
    private $intelligence;

    /**
     * @ORM\Column(type="integer")
     */
    private $forceMusculaire;

    /**
     * @ORM\Column(type="integer")
     */
    private $vitesse;

    /**
     * @ORM\Column(type="integer")
     */
    private $endurance;

    /**
     * @ORM\Column(type="integer")
     */
    private $puissance;

    /**
     * @ORM\Column(type="integer")
     */
    private $combat;

    /**
     * @ORM\ManyToOne(targetEntity=Hero::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $hero;

    /**
     * @ORM\Column(type="integer")
     */
    private $vie;

    /**
     * @ORM\Column(type="integer")
     */
    private $pointsAttaque;

    /**
     * @ORM\Column(type="integer")
     */
    private $pointsEsquive;

    /**
     * @ORM\Column(type="integer")
     */
    private $pointsDefense;

    /**
     * @ORM\Column(type="integer")
     */
    private $coordonneesX;

    /**
     * @ORM\Column(type="integer")
     */
    private $coordonneesY;

    /**
     * @ORM\Column(type="text")
     */
    private $image;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getIntelligence(): ?int
    {
        return $this->intelligence;
    }

    public function setIntelligence(int $intelligence): self
    {
        $this->intelligence = $intelligence;

        return $this;
    }

    public function getForceMusculaire(): ?int
    {
        return $this->forceMusculaire;
    }

    public function setForceMusculaire(int $forceMusculaire): self
    {
        $this->forceMusculaire = $forceMusculaire;

        return $this;
    }

    public function getVitesse(): ?int
    {
        return $this->vitesse;
    }

    public function setVitesse(int $vitesse): self
    {
        $this->vitesse = $vitesse;

        return $this;
    }

    public function getEndurance(): ?int
    {
        return $this->endurance;
    }

    public function setEndurance(int $endurance): self
    {
        $this->endurance = $endurance;

        return $this;
    }

    public function getPuissance(): ?int
    {
        return $this->puissance;
    }

    public function setPuissance(int $puissance): self
    {
        $this->puissance = $puissance;

        return $this;
    }

    public function getCombat(): ?int
    {
        return $this->combat;
    }

    public function setCombat(int $combat): self
    {
        $this->combat = $combat;

        return $this;
    }

    public function getHero(): ?Hero
    {
        return $this->hero;
    }

    public function setHero(?Hero $hero): self
    {
        $this->hero = $hero;

        return $this;
    }

    public function getVie(): ?int
    {
        return $this->vie;
    }

    public function setVie(int $vie): self
    {
        $this->vie = $vie;

        return $this;
    }

    public function getPointsAttaque(): ?int
    {
        return $this->pointsAttaque;
    }

    public function setPointsAttaque(int $pointsAttaque): self
    {
        $this->pointsAttaque = $pointsAttaque;

        return $this;
    }

    public function getPointsEsquive(): ?int
    {
        return $this->pointsEsquive;
    }

    public function setPointsEsquive(int $pointsEsquive): self
    {
        $this->pointsEsquive = $pointsEsquive;

        return $this;
    }

    public function getPointsDefense(): ?int
    {
        return $this->pointsDefense;
    }

    public function setPointsDefense(int $pointsDefense): self
    {
        $this->pointsDefense = $pointsDefense;

        return $this;
    }

    public function getCoordonneesX(): ?int
    {
        return $this->coordonneesX;
    }

    public function setCoordonneesX(int $coordonneesX): self
    {
        $this->coordonneesX = $coordonneesX;

        return $this;
    }

    public function getCoordonneesY(): ?int
    {
        return $this->coordonneesY;
    }

    public function setCoordonneesY(int $coordonneesY): self
    {
        $this->coordonneesY = $coordonneesY;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
}

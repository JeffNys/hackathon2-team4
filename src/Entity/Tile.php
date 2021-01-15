<?php

namespace App\Entity;

use App\Entity\Pieges;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TileRepository")
 */
class Tile
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $coordX;

    /**
     * @ORM\Column(type="integer")
     */
    private $coordY;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasTreasure = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasObject;

    /**
     * @ORM\ManyToOne(targetEntity=Objects::class)
     */
    private $objet;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasEnnemy;

    // manque les ennemy

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasArmes;

    /**
     * @ORM\ManyToOne(targetEntity=Armes::class)
     */
    private $arme;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasPieges;

    /**
     * @ORM\ManyToOne(targetEntity=Pieges::class)
     */
    private $piege;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCoordX(): ?int
    {
        return $this->coordX;
    }

    public function setCoordX(int $coordX): self
    {
        $this->coordX = $coordX;

        return $this;
    }

    public function getCoordY(): ?int
    {
        return $this->coordY;
    }

    public function setCoordY(int $coordY): self
    {
        $this->coordY = $coordY;

        return $this;
    }

    public function getHasTreasure(): ?bool
    {
        return $this->hasTreasure;
    }

    public function setHasTreasure(bool $hasTreasure): self
    {
        $this->hasTreasure = $hasTreasure;

        return $this;
    }

    public function getHasObject(): ?bool
    {
        return $this->hasObject;
    }

    public function setHasObject(bool $hasObject): self
    {
        $this->hasObject = $hasObject;

        return $this;
    }

    public function getHasEnnemy(): ?bool
    {
        return $this->hasEnnemy;
    }

    public function setHasEnnemy(bool $hasEnnemy): self
    {
        $this->hasEnnemy = $hasEnnemy;

        return $this;
    }

    public function getObjet(): ?Objects
    {
        return $this->objet;
    }

    public function setObjet(?Objects $objet): self
    {
        $this->objet = $objet;

        return $this;
    }

    public function getHasArmes(): ?bool
    {
        return $this->hasArmes;
    }

    public function setHasArmes(bool $hasArmes): self
    {
        $this->hasArmes = $hasArmes;

        return $this;
    }

    public function getArme(): ?Armes
    {
        return $this->arme;
    }

    public function setArme(?Armes $arme): self
    {
        $this->arme = $arme;

        return $this;
    }

    public function getHasPieges(): ?bool
    {
        return $this->hasPieges;
    }

    public function setHasPieges(bool $hasPieges): self
    {
        $this->hasPieges = $hasPieges;

        return $this;
    }

    public function getPiege(): ?Pieges
    {
        return $this->piege;
    }

    public function setPiege(?Pieges $piege): self
    {
        $this->piege = $piege;

        return $this;
    }
}

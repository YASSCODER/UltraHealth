<?php

namespace App\Entity;

use App\Repository\IngrediantRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=IngrediantRepository::class)
 */
class Ingrediant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $titre;

    /**
     * @ORM\Column(type="integer")
     */
    private $caloris;

    /**
     * @ORM\Column(type="float")
     */
    private $poids;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getCaloris(): ?int
    {
        return $this->caloris;
    }

    public function setCaloris(int $caloris): self
    {
        $this->caloris = $caloris;

        return $this;
    }

    public function getPoids(): ?float
    {
        return $this->poids;
    }

    public function setPoids(float $poids): self
    {
        $this->poids = $poids;

        return $this;
    }
}

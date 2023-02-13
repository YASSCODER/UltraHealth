<?php

namespace App\Entity;

use App\Repository\IngrediantRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngrediantRepository::class)]
class Ingrediant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $titre = null;

    #[ORM\Column]
    private ?int $caloris = null;

    #[ORM\Column]
    private ?float $poids = null;

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

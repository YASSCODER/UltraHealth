<?php

namespace App\Entity;

use App\Repository\IngrediantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: IngrediantRepository::class)]
class Ingrediant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
 
    #[ORM\Column(length: 30)]   
    #[Assert\NotNull(message: 'Please enter a value.')]
    #[Assert\Type('string', message: 'Please enter a valid name.')]
    private ?string $titre = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'This field can not be empty')]
    #[Assert\Positive(message: 'Please enter a positive number')]
    private ?int $caloris = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'This field can not be empty')]
    #[Assert\Positive(message: 'Please enter a positive number')]
    private ?float $poids = null;


    public function __construct()
    {
        $this->plats = new ArrayCollection();
    }


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

    /**
     * @return Collection<int, Plat>
     */
    public function getPlats(): Collection
    {
        return $this->plats;
    }

    public function addPlat(Plat $plat): self
    {
        if (!$this->plats->contains($plat)) {
            $this->plats->add($plat);
            $plat->addIngrediant($this);
        }

        return $this;
    }

    public function removePlat(Plat $plat): self
    {
        if ($this->plats->removeElement($plat)) {
            $plat->removeIngrediant($this);
        }

        return $this;
    }
    public function __toString()
    {
        return $this->titre;
    }

}

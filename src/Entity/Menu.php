<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MenuRepository::class)
 */
class Menu
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
     * @ORM\ManyToOne(targetEntity=MenuCategorie::class, inversedBy="menus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="menus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $nutritioniste;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="menuClient", orphanRemoval=true)
     */
    private $client;

    public function __construct()
    {
        $this->client = new ArrayCollection();
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

    public function getCategory(): ?MenuCategorie
    {
        return $this->category;
    }

    public function setCategory(?MenuCategorie $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getNutritioniste(): ?User
    {
        return $this->nutritioniste;
    }

    public function setNutritioniste(?User $nutritioniste): self
    {
        $this->nutritioniste = $nutritioniste;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getClient(): Collection
    {
        return $this->client;
    }

    public function addClient(User $client): self
    {
        if (!$this->client->contains($client)) {
            $this->client[] = $client;
            $client->setMenuClient($this);
        }

        return $this;
    }

    public function removeClient(User $client): self
    {
        if ($this->client->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getMenuClient() === $this) {
                $client->setMenuClient(null);
            }
        }

        return $this;
    }
}

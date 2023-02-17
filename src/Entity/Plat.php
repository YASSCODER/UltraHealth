<?php

namespace App\Entity;

use App\Repository\PlatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlatRepository::class)]
class Plat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $titre = null;

    #[ORM\ManyToOne(inversedBy: 'plats')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ingrediant $ingrediants = null;

    #[ORM\Column]
    private ?int $caloris = null;

    #[ORM\OneToMany(mappedBy: 'plats', targetEntity: Menu::class)]
    private Collection $menus;

    public function __construct()
    {
        $this->menus = new ArrayCollection();
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

    public function getIngrediants(): ?Ingrediant
    {
        return $this->ingrediants;
    }

    public function setIngrediants(?Ingrediant $ingrediants): self
    {
        $this->ingrediants = $ingrediants;

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

    /**
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus->add($menu);
            $menu->setPlats($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            // set the owning side to null (unless already changed)
            if ($menu->getPlats() === $this) {
                $menu->setPlats(null);
            }
        }

        return $this;
    }
}

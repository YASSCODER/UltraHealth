<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $titre = null;

    #[ORM\ManyToOne(inversedBy: 'menus')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MenuCategory $category = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'menus')]
    private Collection $UserMenu;

    public function __construct()
    {
        $this->UserMenu = new ArrayCollection();
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

    public function getCategory(): ?MenuCategory
    {
        return $this->category;
    }

    public function setCategory(?MenuCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserMenu(): Collection
    {
        return $this->UserMenu;
    }

    public function addUserMenu(User $userMenu): self
    {
        if (!$this->UserMenu->contains($userMenu)) {
            $this->UserMenu->add($userMenu);
        }

        return $this;
    }

    public function removeUserMenu(User $userMenu): self
    {
        $this->UserMenu->removeElement($userMenu);

        return $this;
    }
}

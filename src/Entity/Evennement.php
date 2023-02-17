<?php

namespace App\Entity;

use App\Repository\EvennementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvennementRepository::class)]
class Evennement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIMETZ_IMMUTABLE)]
    private ?\DateTimeImmutable $dateDebut = null;

    #[ORM\Column(type: Types::DATETIMETZ_IMMUTABLE)]
    private ?\DateTimeImmutable $dateFin = null;

    #[ORM\ManyToOne(inversedBy: 'evennements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?EventCategory $category = null;

    #[ORM\OneToMany(mappedBy: 'evennement', targetEntity: Passe::class, orphanRemoval: true)]
    private Collection $passes;

    public function __construct()
    {
        $this->passes = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeImmutable
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeImmutable $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeImmutable
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeImmutable $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getCategory(): ?EventCategory
    {
        return $this->category;
    }

    public function setCategory(?EventCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Passe>
     */
    public function getPasses(): Collection
    {
        return $this->passes;
    }

    public function addPass(Passe $pass): self
    {
        if (!$this->passes->contains($pass)) {
            $this->passes->add($pass);
            $pass->setEvennement($this);
        }

        return $this;
    }

    public function removePass(Passe $pass): self
    {
        if ($this->passes->removeElement($pass)) {
            // set the owning side to null (unless already changed)
            if ($pass->getEvennement() === $this) {
                $pass->setEvennement(null);
            }
        }

        return $this;
    }
}

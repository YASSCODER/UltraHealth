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

    #[ORM\Column(length: 50)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column(length: 255)]
    private ?string $zone = null;

    #[ORM\OneToMany(mappedBy: 'evennement', targetEntity: Passe::class)]
    private Collection $passe;

    public function __construct()
    {
        $this->passe = new ArrayCollection();
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

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getZone(): ?string
    {
        return $this->zone;
    }

    public function setZone(string $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    /**
     * @return Collection<int, Passe>
     */
    public function getPasse(): Collection
    {
        return $this->passe;
    }

    public function addPasse(Passe $passe): self
    {
        if (!$this->passe->contains($passe)) {
            $this->passe->add($passe);
            $passe->setEvennement($this);
        }

        return $this;
    }

    public function removePasse(Passe $passe): self
    {
        if ($this->passe->removeElement($passe)) {
            // set the owning side to null (unless already changed)
            if ($passe->getEvennement() === $this) {
                $passe->setEvennement(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\RendezVousRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RendezVousRepository::class)]
class RendezVous
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_At = null;

    #[ORM\Column(length: 15)]
    private ?string $etat = null;

    #[ORM\ManyToOne(inversedBy: 'rendezVouses')]
    private ?User $creator = null;

    #[ORM\OneToOne(inversedBy: 'rendezVous', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?FichePatient $fichePatient = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_At;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_At): self
    {
        $this->updated_At = $updated_At;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): self
    {
        $this->creator = $creator;

        return $this;
    }

    public function getFichePatient(): ?FichePatient
    {
        return $this->fichePatient;
    }

    public function setFichePatient(FichePatient $fichePatient): self
    {
        $this->fichePatient = $fichePatient;

        return $this;
    }
}

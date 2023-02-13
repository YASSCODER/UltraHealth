<?php

namespace App\Entity;

use App\Repository\FichePatientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FichePatientRepository::class)]
class FichePatient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $numSeance = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\OneToOne(inversedBy: 'fichePatient', cascade: ['persist', 'remove'])]
    private ?User $userData = null;

    #[ORM\OneToOne(mappedBy: 'fichePatient', cascade: ['persist', 'remove'])]
    private ?RendezVous $rendezVous = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumSeance(): ?int
    {
        return $this->numSeance;
    }

    public function setNumSeance(int $numSeance): self
    {
        $this->numSeance = $numSeance;

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

    public function getUserData(): ?User
    {
        return $this->userData;
    }

    public function setUserData(?User $userData): self
    {
        $this->userData = $userData;

        return $this;
    }

    public function getRendezVous(): ?RendezVous
    {
        return $this->rendezVous;
    }

    public function setRendezVous(RendezVous $rendezVous): self
    {
        // set the owning side of the relation if necessary
        if ($rendezVous->getFichePatient() !== $this) {
            $rendezVous->setFichePatient($this);
        }

        $this->rendezVous = $rendezVous;

        return $this;
    }
}

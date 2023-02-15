<?php

namespace App\Entity;

use App\Repository\FichePatientRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FichePatientRepository::class)
 */
class FichePatient
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $numSeance;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="fichePatient", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $patient;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="fichePatient", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $medecin;

    /**
     * @ORM\OneToOne(targetEntity=RendezVous::class, mappedBy="fiche", cascade={"persist", "remove"})
     */
    private $rendezVous;

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

    public function getPatient(): ?User
    {
        return $this->patient;
    }

    public function setPatient(User $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    public function getMedecin(): ?User
    {
        return $this->medecin;
    }

    public function setMedecin(User $medecin): self
    {
        $this->medecin = $medecin;

        return $this;
    }

    public function getRendezVous(): ?RendezVous
    {
        return $this->rendezVous;
    }

    public function setRendezVous(RendezVous $rendezVous): self
    {
        // set the owning side of the relation if necessary
        if ($rendezVous->getFiche() !== $this) {
            $rendezVous->setFiche($this);
        }

        $this->rendezVous = $rendezVous;

        return $this;
    }
}

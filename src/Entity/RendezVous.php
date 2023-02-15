<?php

namespace App\Entity;

use App\Repository\RendezVousRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RendezVousRepository::class)
 */
class RendezVous
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $dateRdv;

    /**
     * @ORM\OneToOne(targetEntity=FichePatient::class, inversedBy="rendezVous", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $fiche;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="rendezVouses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $UserCreator;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateRdv(): ?\DateTimeInterface
    {
        return $this->dateRdv;
    }

    public function setDateRdv(\DateTimeInterface $dateRdv): self
    {
        $this->dateRdv = $dateRdv;

        return $this;
    }

    public function getFiche(): ?FichePatient
    {
        return $this->fiche;
    }

    public function setFiche(FichePatient $fiche): self
    {
        $this->fiche = $fiche;

        return $this;
    }

    public function getUserCreator(): ?User
    {
        return $this->UserCreator;
    }

    public function setUserCreator(?User $UserCreator): self
    {
        $this->UserCreator = $UserCreator;

        return $this;
    }
}

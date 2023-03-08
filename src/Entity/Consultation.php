<?php

namespace App\Entity;


use App\Repository\ConsultationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;     

#[ORM\Entity(repositoryClass: ConsultationRepository::class)]
class Consultation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $traitement = null;

    #[ORM\Column]
    #[Assert\Positive]

    private ?int $numSeance = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]

    private ?string $description = null;

    #[ORM\OneToOne(inversedBy: 'consultation', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]

    private ?RendezVous $rendezVous = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTraitement(): ?string
    {
        return $this->traitement;
    }

    public function setTraitement(string $traitement): self
    {
        $this->traitement = $traitement;

        return $this;
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

    public function getRendezVous(): ?RendezVous
    {
        return $this->rendezVous;
    }

    public function setRendezVous(RendezVous $rendezVous): self
    {
        $this->rendezVous = $rendezVous;

        return $this;
    }


    public function __toString()
    {
        return $this->id;
    }
    
}


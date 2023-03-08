<?php

namespace App\Entity;

use App\Repository\EvennementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EvennementRepository::class)]
class Evennement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "titre evennement ne peux pas être vide! ")]
    #[Assert\Length(
        min: 3,
        max: 10,
        minMessage: "The name must be at least {{ limit }} characters long",
        maxMessage: "The name cannot be longer than {{ limit }} characters"
    )]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "description evennement ne peux pas être vide! ")]
    #[Assert\Length(
        min: 7,
        max: 20,
        minMessage: "The name must be at least {{ limit }} characters long",
        maxMessage: "The name cannot be longer than {{ limit }} characters"
    )]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\GreaterThan("today", message: "date inferieur a aujourd'hui.")]
    #[Assert\NotBlank(message: "description evennement ne peux pas être vide! ")]
    #[Assert\NotNull(message: "description evennement ne peux pas être vide! ")]
    //#[Assert\DateTime(message: "description evennement ne peux pas être vide! ")]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank(message: "description evennement ne peux pas être vide! ")]
    #[Assert\NotNull(message: "description evennement ne peux pas être vide! ")]
    // #[Assert\DateTime(message: "description evennement ne peux pas être vide! ")]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "zone evennement ne peux pas être vide! ")]
    #[Assert\Length(
        min: 3,
        max: 20,
        minMessage: "The name must be at least {{ limit }} characters long",
        maxMessage: "The name cannot be longer than {{ limit }} characters"
    )]
    private ?string $zone = null;

    #[ORM\ManyToOne(inversedBy: 'evennements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?EventCategory $category = null;

    #[ORM\OneToOne(mappedBy: 'evennement', cascade: ['persist', 'remove'])]
    private ?Passe $passe = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $eventimg = null;




    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(message: "nombre passe ne peux pas être vide! ")]
    #[Assert\Positive(message: "nombre passe doit etre positive! ")]
    private ?int $nbrPasse = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(message: "price evennement ne peux pas être vide! ")]
    #[Assert\Positive(message: "price doit etre positive! ")]
    private ?float $prix = null;

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

    public function getCategory(): ?EventCategory
    {
        return $this->category;
    }

    public function setCategory(?EventCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getPasse(): ?Passe
    {
        return $this->passe;
    }

    public function setPasse(Passe $passe): self
    {
        // set the owning side of the relation if necessary
        if ($passe->getEvennement() !== $this) {
            $passe->setEvennement($this);
        }

        $this->passe = $passe;

        return $this;
    }
    public function __toString()
    {
        return $this->titre;
    }

    public function getEventimg(): ?string
    {
        return  $this->eventimg;
    }


    public function setEventimg(?string $eventimg): self
    {
        $this->eventimg = $eventimg;

        // Save the file path to the database
        return $this;
    }

    public function getNbrPasse(): ?int
    {
        return $this->nbrPasse;
    }

    public function setNbrPasse(?int $nbrPasse): self
    {
        $this->nbrPasse = $nbrPasse;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
}

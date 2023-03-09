<?php

namespace App\Entity;

use App\Repository\PasseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PasseRepository::class)]
class Passe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $code = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\OneToOne(inversedBy: 'passe', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Evennement $evennement = null;

    #[ORM\ManyToOne(inversedBy: 'Passe')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $utilisateur = null;

    public function __construct($price = null, $event = null)
    {
        $this->code = uniqid();
        $this->prix = $price;
        $this->evennement = $event;
        $this->utilisateur = null;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getEvennement(): ?Evennement
    {
        return $this->evennement;
    }

    public function setEvennement(Evennement $evennement): self
    {
        $this->evennement = $evennement;

        return $this;
    }


    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }
}

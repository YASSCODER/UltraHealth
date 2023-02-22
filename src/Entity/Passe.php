<?php

namespace App\Entity;

use App\Repository\PasseRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PasseRepository::class)]
class Passe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "code ne peux pas être vide! ")]
    #[Assert\Length(
        min: 3,
        max: 10,
        minMessage: "The name must be at least {{ limit }} characters long",
        maxMessage: "The name cannot be longer than {{ limit }} characters"
    )]
    private ?string $code = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "price evennement ne peux pas être vide! ")]
    #[Assert\Positive(message: "price doit etre positive! ")]
    private ?float $prix = null;

    #[ORM\OneToOne(inversedBy: 'passe', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Evennement $evennement = null;

    #[ORM\ManyToOne(inversedBy: 'Passe')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $PasseOwner = null;

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

    public function getPasseOwner(): ?User
    {
        return $this->PasseOwner;
    }

    public function setPasseOwner(?User $PasseOwner): self
    {
        $this->PasseOwner = $PasseOwner;

        return $this;
    }
}

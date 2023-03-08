<?php

namespace App\Entity;

use App\Repository\CommantaireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommantaireRepository::class)]
class Commantaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;


    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\ManyToOne(inversedBy: 'commantaires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Article $poste = null;

    #[ORM\ManyToOne(inversedBy: 'commantaire')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;


    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function gettitre(): ?string
    {
        return $this->titre;
    }

    public function settitre(string $titre): self
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getPoste(): ?Article
    {
        return $this->poste;
    }

    public function setPoste(?Article $poste): self
    {
        $this->poste = $poste;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }
    public function __toString()
    {
        return $this->getTitre(); // replace getTitle() with the appropriate method to get a string representation of the Article object
    }
    
}

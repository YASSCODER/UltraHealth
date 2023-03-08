<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    
    /**
     * @Assert\NotBlank(message=" titre doit etre non vide")
     * @Assert\Length(
     *      min = 5,
     *      minMessage=" Entrer un titre au mini de 5 caracteres"
     *
     *     )
     * @ORM\Column(type="string", length=255)
     */
    #[ORM\Column(length: 30)]
    private ?string $titre = null;

    /**
     * @Assert\NotBlank(message="description  doit etre non vide")
     * @Assert\Length(
     *      min = 20,
     *      max = 200,
     *      minMessage = "doit etre >=20 ",
     *      maxMessage = "doit etre <=200" )
     * @ORM\Column(type="string", length=1000)
     */
    #[ORM\Column(length: 255)]
    private ?string $description = null;
    

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\OneToMany(mappedBy: 'poste', targetEntity: Commantaire::class, orphanRemoval: true)]
    private Collection $commantaires;

    #[ORM\ManyToOne(inversedBy: 'article')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;
    
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    /**
 * @ORM\Column(type="integer")
 */
private $likes = 0;

/**
 * @ORM\Column(type="integer")
 */
private $dislikes = 0;
   

    public function __construct()
    {
        $this->commantaires = new ArrayCollection();
       
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
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection<int, Commantaire>
     */
    public function getCommantaires(): Collection
    {
        return $this->commantaires;
    }

    public function addCommantaire(Commantaire $commantaire): self
    {
        if (!$this->commantaires->contains($commantaire)) {
            $this->commantaires->add($commantaire);
            $commantaire->setPoste($this);
        }

        return $this;
    }

    public function removeCommantaire(Commantaire $commantaire): self
    {
        if ($this->commantaires->removeElement($commantaire)) {
            // set the owning side to null (unless already changed)
            if ($commantaire->getPoste() === $this) {
                $commantaire->setPoste(null);
            }
        }

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
    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
    public function __toString()
    {
        return $this->getTitre(); // replace getTitle() with the appropriate method to get a string representation of the Article object
    }
    
      /**
     * Get the number of comments associated with the article.
     *
     * @return int
     */
    public function getCommentCount(): int
    {
        return $this->commantaires->count();
    }
   


  


}

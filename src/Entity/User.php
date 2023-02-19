<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 8)]
    private ?string $cin = null;

    #[ORM\Column(length: 30)]
    private ?string $nom = null;

    #[ORM\Column(length: 30)]
    private ?string $prenom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\Column(length: 255)]
    private ?string $zone = null;

    #[ORM\Column(length: 50)]
    private ?string $email = null;

    #[ORM\Column(length: 30)]
    private ?string $password = null;

    #[ORM\Column(length: 30)]
    private ?string $role = null;

    #[ORM\OneToMany(mappedBy: 'commandeOwner', targetEntity: Commande::class)]
    private Collection $commande;

    #[ORM\OneToMany(mappedBy: 'PasseOwner', targetEntity: Passe::class)]
    private Collection $Passe;

    #[ORM\OneToMany(mappedBy: 'userOwner', targetEntity: Menu::class)]
    private Collection $menu;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Article::class)]
    private Collection $article;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Question::class)]
    private Collection $question;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Reponse::class)]
    private Collection $reponse;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Commantaire::class)]
    private Collection $commantaire;

    public function __construct()
    {
        $this->commande = new ArrayCollection();
        $this->Passe = new ArrayCollection();
        $this->menu = new ArrayCollection();
        $this->article = new ArrayCollection();
        $this->question = new ArrayCollection();
        $this->reponse = new ArrayCollection();
        $this->commantaire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(string $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommande(): Collection
    {
        return $this->commande;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commande->contains($commande)) {
            $this->commande->add($commande);
            $commande->setCommandeOwner($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commande->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getCommandeOwner() === $this) {
                $commande->setCommandeOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Passe>
     */
    public function getPasse(): Collection
    {
        return $this->Passe;
    }

    public function addPasse(Passe $passe): self
    {
        if (!$this->Passe->contains($passe)) {
            $this->Passe->add($passe);
            $passe->setPasseOwner($this);
        }

        return $this;
    }

    public function removePasse(Passe $passe): self
    {
        if ($this->Passe->removeElement($passe)) {
            // set the owning side to null (unless already changed)
            if ($passe->getPasseOwner() === $this) {
                $passe->setPasseOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Menu>
     */
    public function getMenu(): Collection
    {
        return $this->menu;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menu->contains($menu)) {
            $this->menu->add($menu);
            $menu->setUserOwner($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menu->removeElement($menu)) {
            // set the owning side to null (unless already changed)
            if ($menu->getUserOwner() === $this) {
                $menu->setUserOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticle(): Collection
    {
        return $this->article;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->article->contains($article)) {
            $this->article->add($article);
            $article->setAuthor($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->article->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getAuthor() === $this) {
                $article->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Question>
     */
    public function getQuestion(): Collection
    {
        return $this->question;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->question->contains($question)) {
            $this->question->add($question);
            $question->setAuthor($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->question->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getAuthor() === $this) {
                $question->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reponse>
     */
    public function getReponse(): Collection
    {
        return $this->reponse;
    }

    public function addReponse(Reponse $reponse): self
    {
        if (!$this->reponse->contains($reponse)) {
            $this->reponse->add($reponse);
            $reponse->setAuthor($this);
        }

        return $this;
    }

    public function removeReponse(Reponse $reponse): self
    {
        if ($this->reponse->removeElement($reponse)) {
            // set the owning side to null (unless already changed)
            if ($reponse->getAuthor() === $this) {
                $reponse->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commantaire>
     */
    public function getCommantaire(): Collection
    {
        return $this->commantaire;
    }

    public function addCommantaire(Commantaire $commantaire): self
    {
        if (!$this->commantaire->contains($commantaire)) {
            $this->commantaire->add($commantaire);
            $commantaire->setAuthor($this);
        }

        return $this;
    }

    public function removeCommantaire(Commantaire $commantaire): self
    {
        if ($this->commantaire->removeElement($commantaire)) {
            // set the owning side to null (unless already changed)
            if ($commantaire->getAuthor() === $this) {
                $commantaire->setAuthor(null);
            }
        }

        return $this;
    }
}

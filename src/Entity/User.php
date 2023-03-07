<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 8)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 8,
        max: 8,
        minMessage: 'Your CIN must be at least {{ limit }} 8 characters',
        maxMessage: 'Your CIN must be at least {{ limit }} 8 characters',
    )]
    private ?string $cin = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank]
    private ?string $nom = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank]
    private ?string $prenom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $zone = null;

    #[ORM\Column(length: 50)]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    private ?string $email = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank]
    private ?string $password = null;

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

    #[ORM\Column(type: Types::JSON)]
    private array $role = [];

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

 /**
         * @see UserInterface
    */
    public function getUserIdentifier(): ?string
    {
        return $this->email;
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
/**
         * A visual identifier that represents this user.
         *
         * @see UserInterface
         */
        public function getUsername(): string
        {
                return (string) $this->nom;
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

    public function getemail(): ?string
    {
        return $this->email;
    }

    public function setemail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
         * @see UserInterface
    */
    public function getpassword(): ?string
    {
        return $this->password;
    }

    public function setpassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
         * @see UserInterface
         */
        public function getRoles(): array
        {
                $roles = $this->role;
                return array_unique($roles);
        }
     /**
         * @see UserInterface
         */
        public function eraseCredentials()
        {
                // If you store any temporary, sensitive data on the user, clear it here
                // $this->plainPassword = null;
        }
    /**
         * @see UserInterface
         */
        public function getSalt()
        {
                // not needed when using the "bcrypt" algorithm in security.yaml
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

    public function getRole(): array
    {
        return $this->role;
    }

    public function setRole(array $role): self
    {
        $this->role = $role;

        return $this;
    }
}

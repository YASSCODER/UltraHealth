<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: Categorie::class)]
    private Collection $category;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: Reponse::class)]
    private Collection $reponses;

    #[ORM\ManyToOne(inversedBy: 'questions')]
    private ?User $UserQuestion = null;

    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->reponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Categorie>
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Categorie $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category->add($category);
            $category->setQuestion($this);
        }

        return $this;
    }

    public function removeCategory(Categorie $category): self
    {
        if ($this->category->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getQuestion() === $this) {
                $category->setQuestion(null);
            }
        }

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
     * @return Collection<int, Reponse>
     */
    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function addReponse(Reponse $reponse): self
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses->add($reponse);
            $reponse->setQuestion($this);
        }

        return $this;
    }

    public function removeReponse(Reponse $reponse): self
    {
        if ($this->reponses->removeElement($reponse)) {
            // set the owning side to null (unless already changed)
            if ($reponse->getQuestion() === $this) {
                $reponse->setQuestion(null);
            }
        }

        return $this;
    }

    public function getUserQuestion(): ?User
    {
        return $this->UserQuestion;
    }

    public function setUserQuestion(?User $UserQuestion): self
    {
        $this->UserQuestion = $UserQuestion;

        return $this;
    }
}

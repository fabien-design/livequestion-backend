<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["question:read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["question:read"])]
    private ?string $title = null;

    #[ORM\ManyToOne(inversedBy: 'question')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["question:read"])]
    private ?User $author = null;

    #[ORM\OneToOne(mappedBy: 'question', cascade: ['persist', 'remove'])]
    #[Groups(["question:read"])]
    private ?Images $images = null;
    
    #[ORM\ManyToOne(targetEntity: Category::class,inversedBy:'questions')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["question:read"])]
    
    private ?Category $category;

    /**
     * @var Collection<int, Answer>
     */
    #[ORM\OneToMany(targetEntity: Answer::class, mappedBy: 'question', orphanRemoval: true)]
    #[Groups(["question:read"])]
    private Collection $answers;

    // #[ORM\Column(nullable: true)]
    // #[Gedmo\Timestampable(on:'create')]
    // private ?\DateTimeImmutable $created_at = null;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }

    public function __toString()
    {
        return "Question n°" . $this->id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getImages(): ?Images
    {
        return $this->images;
    }

    public function setImages(Images $images): static
    {
        // set the owning side of the relation if necessary
        if ($images->getQuestion() !== $this) {
            $images->setQuestion($this);
        }

        $this->images = $images;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Answer>
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): static
    {
        if (!$this->answers->contains($answer)) {
            $this->answers->add($answer);
            $answer->setQuestion($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): static
    {
        if ($this->answers->removeElement($answer)) {
            // set the owning side to null (unless already changed)
            if ($answer->getQuestion() === $this) {
                $answer->setQuestion(null);
            }
        }

        return $this;
    }
}

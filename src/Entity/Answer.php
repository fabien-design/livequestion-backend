<?php

namespace App\Entity;

use App\Repository\AnswerRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AnswerRepository::class)]
class Answer
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["question:read"])]
    private ?int $id = null;

    #[ORM\Column(length: 512)]
    #[Groups(["question:read"])]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'answer')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["question:read"])]
    private ?User $author = null;

    #[ORM\ManyToOne(inversedBy: 'answer')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Question $question = null;

    public function __toString()
    {
        return $this->content;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

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

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): static
    {
        $this->question = $question;

        return $this;
    }
}

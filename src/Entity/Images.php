<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use App\Service\ImageUploader as ImageUploader;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints\Image;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Vich\UploaderBundle\Naming\NamerInterface;
use Vich\UploaderBundle\Mapping\PropertyMapping;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ImagesRepository::class)]
#[Vich\Uploadable]
class Images
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["question.index", "question.show", "user.index", "user.show"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["question.index", "question.show", "user.index", "user.show"])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(["question.show"])]
    private ?string $original_name = null;

    #[ORM\Column(length: 255)]
    #[Groups(["question.show"])]
    private ?string $extension = null;

    #[ORM\Column]
    #[Groups(["question.show"])]
    private ?int $size = null;

    #[ORM\Column(type: 'datetime')]
    #[Gedmo\Timestampable(on: 'update')]
    #[Groups(["question.show"])]
    private ?\DateTimeInterface $updated_at = null;

    #[Vich\UploadableField(mapping: 'question_image', fileNameProperty: 'name', originalName: 'original_name', size: 'size', mimeType:'extension')]
    private ?File $imageFile = null;

    #[ORM\OneToOne(mappedBy: 'images', cascade: ['persist', 'remove'])]
    private ?Question $question = null;

    #[ORM\OneToOne(mappedBy: 'avatar', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;
        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updated_at = new \DateTimeImmutable();
            
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getOriginalName(): ?string
    {
        return $this->original_name;
    }

    public function setOriginalName(string $original_name): static
    {
        $this->original_name = $original_name;

        return $this;
    }

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    public function setExtension(string $extension): static
    {
        $this->extension = $extension;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(Question $question): static
    {
        $this->question = $question;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;
        
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}

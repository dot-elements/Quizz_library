<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    #[ORM\Column(length: 255)]
    private ?string $type = 'multiple_choice';

    #[ORM\Column(nullable: true)]
    private ?array $options = null;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'questions')]
    private ?Category $category = null;

    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'questions')]
    private Collection $tags;

    #[ORM\ManyToMany(targetEntity: QuizVersion::class, mappedBy: 'questions')]
    private Collection $quizVersions;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->quizVersions = new ArrayCollection();
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }
    public function getTags(): ?Collection
    {
        return $this->tags;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getOptions(): ?array
    {
        return $this->options;
    }

    public function setOptions(?array $options): static
    {
        $this->options = $options;

        return $this;
    }

    public function setQuizVersion(?QuizVersion $quizVersion): static
    {
        $this->quizVersion = $quizVersion;

        return $this;
    }
}

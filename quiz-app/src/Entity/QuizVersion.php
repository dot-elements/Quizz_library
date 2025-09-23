<?php

namespace App\Entity;

use App\Repository\QuizVersionRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuizVersionRepository::class)]
class QuizVersion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $version = '1.0.0';

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;


    #[ORM\ManyToOne(inversedBy: 'versions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Quiz $quiz = null;

    #[ORM\ManyToMany(targetEntity: Question::class, inversedBy: 'quizVersions')]
    #[ORM\JoinTable(name: 'quiz_version_question')]
    private Collection $questions;

    #[ORM\OneToMany(targetEntity: ClientQuiz::class, mappedBy: 'quizVersion', cascade: ['persist'], orphanRemoval: true)]
    private Collection $clientQuizzes;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->clientQuizzes = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getQuiz(): ?Quiz
    {
        return $this->quiz;
    }
    public function getQuestions(): ?Collection
    {
        return $this->questions;
    }

    public function setQuestions(Collection $questions): static
    {
        $this->questions = $questions;

        return $this;
    }

    public function addQuestion(Question $question): static
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
        }
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(string $version): static
    {
        $this->version = $version;

        return $this;
    }

    public function setQuiz( Quiz $quiz ): static
    {
        $this->quiz = $quiz;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}

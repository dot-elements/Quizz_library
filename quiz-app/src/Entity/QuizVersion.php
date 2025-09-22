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

    #[ORM\OneToMany(targetEntity: Question::class, mappedBy: 'quizVersion', cascade: ['persist'], orphanRemoval: true)]
    private Collection $questions;

    #[ORM\OneToMany(targetEntity: ClientQuiz::class, mappedBy: 'quizVersion', cascade: ['persist'], orphanRemoval: true)]
    private Collection $clientQuizzes;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->clientQuizzes = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
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

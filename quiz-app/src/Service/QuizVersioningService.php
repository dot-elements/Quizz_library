<?php

namespace App\Service;

use App\Entity\Quiz;
use App\Entity\QuizVersion;
use Doctrine\ORM\EntityManagerInterface;

class QuizVersioningService
{
    public function __construct() {}

    public function createInitialVersion(Quiz $quiz): QuizVersion
    {
        $version = new QuizVersion();
        $version->setQuiz($quiz);
        $version->setVersion("1.0.0");
        $version->setCreatedAt(new \DateTimeImmutable());


        return $version;
    }

    public function bumpVersion(Quiz $quiz, string $currentVersion): QuizVersion
    {
        // naive bump: just increment minor version
        [$major, $minor, $patch] = explode('.', $currentVersion);
        $minor++;
        if ( $minor == 10 ) {
            $minor = 0;
            $major++;
        }
        $newVersion = "$major.$minor.0";

        $version = new QuizVersion();
        $version->setQuiz($quiz);
        $version->setVersion($newVersion);
        $version->setCreatedAt(new \DateTimeImmutable());


        return $version;
    }
}

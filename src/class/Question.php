<?php

class Question
{
    private int $questId;
    private int $question;
    private int $difficultyId;
    private int $difficulty;
    private int $answers;

    public function __construct(
        int $questId,
        int $question,
        int $difficultyId,
        int $difficulty,
        int $answers
    ) {
        $this->questId = $questId;
        $this->question = $question;
        $this->difficultyId = $difficultyId;
        $this->difficulty = $difficulty;
        $this->answers = $answers;
    }

    // GETTERS //
    public function getQuestId(): int
    {
        return $this->questId;
    }
    public function getQuestion(): int
    {
        return $this->question;
    }
    public function getDifficultyId(): int
    {
        return $this->difficultyId;
    }
    public function getDifficulty(): int
    {
        return $this->difficulty;
    }
    public function getAnswers(): int
    {
        return $this->answers;
    }

    // SETTERS //
    public function setQuestion(int $question)
    {
        $this->question = $question;
    }
    public function setDifficultyId(int $difficultyId)
    {
        $this->difficultyId = $difficultyId;
    }
    public function setDifficulty(int $difficulty)
    {
        $this->difficulty = $difficulty;
    }
    public function setAnswers(int $answers)
    {
        $this->answers = $answers;
    }
}

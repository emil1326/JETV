<?php

class Quest
{

    private int $id;
    private int $question;
    private int $difficultyId;
    private int $difficulty;
    private array $answers;

    public function __construct(
        int $id,
        int $question,
        int $difficultyId,
        int $difficulty,
        array $answers
    ) {
        $this->id = $id;
        $this->question = $question;
        $this->difficultyId = $difficultyId;
        $this->difficulty = $difficulty;
        $this->answers = $answers;
    }

    // GETTERS //
    public function getId(): int
    {
        return $this->id;
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
    public function getAnswers(): array
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
    public function setAnswers(array $answers)
    {
        $this->answers = $answers;
    }
    public function addAnswer(Answer $answer)
    {
        $this->answers[] = $answer;
    }
}

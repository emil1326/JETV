<?php

class Quest
{
    private int $id;
    private string $question;
    private int $difficultyId;
    private string $difficulty;
    private int $pvLoss;
    // private array $answers;

    public function __construct(
        int $id,
        string $question,
        int $difficultyId,
        string $difficulty,
        int $pvLoss
        // array $answers
    ) {
        $this->id = $id;
        $this->question = $question;
        $this->difficultyId = $difficultyId;
        $this->difficulty = $difficulty;
        $this->pvLoss = $pvLoss;
        // $this->answers = $answers;
    }

    // GETTERS //
    public function getId(): int
    {
        return $this->id;
    }
    public function getQuestion(): string
    {
        return $this->question;
    }
    public function getDifficultyId(): int
    {
        return $this->difficultyId;
    }
    public function getDifficulty(): string
    {
        return $this->difficulty;
    }
    public function getPVLoss(): int
    {
        return $this->pvLoss;
    }
    //  public function getAnswers(): array
    //  {
    //      return $this->answers;
    //  }

    // SETTERS //
    public function setQuestion(string $question)
    {
        $this->question = $question;
    }
    public function setDifficultyId(int $difficultyId)
    {
        $this->difficultyId = $difficultyId;
    }
    public function setDifficulty(string $difficulty)
    {
        $this->difficulty = $difficulty;
    }
    //  public function setAnswers(array $answers)
    //  {
    //      $this->answers = $answers;
    //  }
    //  public function addAnswer(Answer $answer)
    //  {
    //      $this->answers[] = $answer;
    //  }
}

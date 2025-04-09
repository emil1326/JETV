<?php

class Answer
{
    private int $questId;
    private string $answer;
    private bool $isCorrect;
    private int $awnserID;

    public function __construct(
        int $questId,
        string $answer,
        bool $isCorrect,
        int $awnserID,
    ) {
        $this->questId = $questId;
        $this->answer = $answer;
        $this->isCorrect = $isCorrect;
        $this->awnserID = $awnserID;
    }

    // GETTERS //
    public function getQuestId(): int
    {
        return $this->questId;
    }
    public function getAnswer(): string
    {
        return $this->answer;
    }
    public function getIsCorrect(): bool
    {
        return $this->isCorrect;
    }
    public function getAwnserID(): int
    {
        return $this->awnserID;
    }

    // SETTERS //
    public function setAnswer(string $answer)
    {
        $this->answer = $answer;
    }
    public function setIsCorrect(bool $isCorrect)
    {
        $this->isCorrect = $isCorrect;
    }
}

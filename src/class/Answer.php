<?php

class Answer
{
    private int $questId;
    private string $answer;
    private bool $isCorrect;

    public function __construct(
        int $questId,
        string $answer,
        bool $isCorrect
    ) {
        $this->questId = $questId;
        $this->answer = $answer;
        $this->isCorrect = $isCorrect;
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

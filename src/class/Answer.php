<?php

class Answer
{
    private int $id;
    private int $questId;
    private string $answer;
    private bool $isCorrect;

    public function __construct(
        int $id,
        int $questId,
        int $answer,
        bool $isCorrect
    ) {
        $this->id = $id;
        $this->questId = $questId;
        $this->answer = $answer;
        $this->isCorrect = $isCorrect;
    }

    // GETTERS //
    public function getId(): int
    {
        return $this->id;
    }
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

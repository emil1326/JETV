<?php

class Evaluation
{
    private int $userId;
    private int $itemId;
    private int $starCount;

    public function __construct(
        int $userId,
        int $itemId,
        int $starCount,
    ) {
        $this->userId = $userId;
        $this->itemId = $itemId;
        $this->starCount = $starCount;
    }

    // GETTERS //
    public function getUserId(): int
    {
        return $this->userId;
    }
    public function getItemId(): int
    {
        return $this->itemId;
    }
    public function getStarCount(): int
    {
        return $this->starCount;
    }

    // SETTERS //
    public function setStarCount(int $starCount)
    {
        $this->starCount = $starCount;
    }
}

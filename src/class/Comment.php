<?php

class Comment
{
    private int $id;
    private int $userId;
    private int $itemId;
    private string $comment;
    private int $starCount;

    public function __construct(
        int $id,
        int $userId,
        int $itemId,
        string $comment,
        int $starCount,
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->itemId = $itemId;
        $this->comment = $comment;
        $this->starCount = $starCount;
    }

    // GETTERS //
    public function getId(): int
    {
        return $this->id;
    }
    public function getUserId(): int
    {
        return $this->userId;
    }
    public function getItemId(): int
    {
        return $this->itemId;
    }
    public function getComment(): string
    {
        return $this->comment;
    }
    public function getStarCount(): int
    {
        return $this->starCount;
    }

    // SETTERS //
    public function setComment(string $comment)
    {
        $this->comment = $comment;
    }
    public function setStarCount(int $starCount)
    {
        $this->starCount = $starCount;
    }
}

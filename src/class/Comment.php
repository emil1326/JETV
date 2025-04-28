<?php

class Comment
{
    private int $id;
    private int $userId;
    private int $itemId;
    private string $comment;

    public function __construct(
        int $id,
        int $userId,
        int $itemId,
        string $comment,
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->itemId = $itemId;
        $this->comment = $comment;
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

    // SETTERS //
    public function setComment(string $comment)
    {
        $this->comment = $comment;
    }
}

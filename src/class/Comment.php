<?php

class Comment
{
    private int $id;
    private int $userId;
    private int $commentId;
    private string $comment;
    private int $evaluation;

    public function __construct(
        int $id,
        int $userId,
        int $commentId,
        string $comment,
        int $evaluation,
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->commentId = $commentId;
        $this->comment = $comment;
        $this->evaluation = $evaluation;
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
    public function getCommentId(): int
    {
        return $this->commentId;
    }
    public function getComment(): string
    {
        return $this->comment;
    }
    public function getEvaluation(): int
    {
        return $this->evaluation;
    }

    // SETTERS //
    public function setComment(string $comment)
    {
        $this->comment = $comment;
    }
    public function setEvaluation(int $evaluation)
    {
        $this->evaluation = $evaluation;
    }
}

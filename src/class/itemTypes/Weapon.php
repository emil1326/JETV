<?php

class Weapon extends Item
{
    private string $efficiency;
    private string $genre;
    private string|null $caliber;

    public function __construct(
        int $id,
        string $type,
        string $name,
        string $description,
        int $itemWeight,
        int $buyPrice,
        int $sellPrice,
        string $imageLink,
        int $utility,
        int $itemStatus,

        string $efficiency,
        string $genre,
        string|null $caliber
    ) {
        $this->efficiency = $efficiency;
        $this->genre = $genre;
        $this->caliber = $caliber;

        parent::__construct(
            $id,
            $type,
            $name,
            $description,
            $itemWeight,
            $buyPrice,
            $sellPrice,
            $imageLink,
            $utility,
            $itemStatus,
        );
    }

    // Getters //
    public function getEfficiency(): string
    {
        return $this->efficiency;
    }
    public function getGenre(): string
    {
        return $this->genre;
    }
    public function getCaliber(): string|null
    {
        return $this->caliber;
    }
    public function getAttributes(): array
    {
        return [
            'efficiency' => $this->getEfficiency(),
            'genre' => $this->getGenre(),
            'caliber' => $this->getCaliber()
        ];
    }

    // SETTERS //
    public function setEfficiency(string $efficiency): void
    {
        $this->efficiency = $efficiency;
    }
    public function setGenre(int $genre): void
    {
        $this->genre = $genre;
    }
    public function setCaliber(int|null $caliber): void
    {
        $this->caliber = $caliber;
    }
}

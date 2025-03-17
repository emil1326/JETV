<?php

class Weapon extends Item
{
    private string $efficiency;
    private string $genre;
    private string $caliber;

    public function __construct(
        string $efficiency,
        string $genre,
        string $caliber
    ) {
        $this->efficiency = $efficiency;
        $this->genre = $genre;
        $this->caliber = $caliber;
    }

    // SETTERS //
    public function getEfficiency(): string
    {
        return $this->efficiency;
    }
    public function getGenre(): string
    {
        return $this->genre;
    }
    public function getCaliber(): string
    {
        return $this->caliber;
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
    public function setCaliber(int $caliber): void
    {
        $this->caliber = $caliber;
    }
}

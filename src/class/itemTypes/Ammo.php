<?php

class Ammo extends Item
{
    private string $caliber;

    public function __construct(
        string $caliber
    ) {
        $this->caliber = $caliber;
    }

    // SETTERS //
    public function getCaliber(): string
    {
        return $this->caliber;
    }

    // SETTERS //
    public function setCaliber(string $caliber): void
    {
        $this->caliber = $caliber;
    }
}

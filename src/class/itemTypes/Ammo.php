<?php

class Ammo extends Item
{
    private string $caliber;

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

        string $caliber
    ) {
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

<?php

class Armor extends Item
{
    private string $material;
    private string $size;

    public function __construct(
        string $material,
        string $size,
    ) {
        $this->material = $material;
        $this->size = $size;
    }

    // SETTERS //
    public function getMaterial(): string
    {
        return $this->material;
    }
    public function getSize(): int
    {
        return $this->size;
    }

    // SETTERS //
    public function setMaterial(string $material): void
    {
        $this->material = $material;
    }
    public function setSize(int $size): void
    {
        $this->size = $size;
    }
}

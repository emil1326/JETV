<?php

class Armor extends Item
{
    private string $material;
    private string $size;

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

        string $material,
        string $size,
    ) {
        $this->material = $material;
        $this->size = $size;

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
    public function getMaterial(): string
    {
        return $this->material;
    }
    public function getSize(): string
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

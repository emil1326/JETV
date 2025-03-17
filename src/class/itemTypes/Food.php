<?php

class Food extends Item
{
    private int $healthGain;
    private string $calories;
    private string $mainNutriment;
    private string $mainMineral;

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

        int $healthGain,
        string $calories,
        string $mainNutriment,
        string $mainMineral
    ) {
        $this->healthGain = $healthGain;
        $this->calories = $calories;
        $this->mainNutriment = $mainNutriment;
        $this->mainMineral = $mainMineral;

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
    public function getHealthGain(): int
    {
        return $this->healthGain;
    }
    public function getCalories(): string
    {
        return $this->calories;
    }
    public function getMainNutriment(): string
    {
        return $this->mainNutriment;
    }
    public function getMainMineral(): string
    {
        return $this->mainMineral;
    }

    // Getters //
    public function setHealthGain(int $healthGain): void
    {
        $this->healthGain = $healthGain;
    }
    public function setCalories(string $calories): void
    {
        $this->calories = $calories;
    }
    public function setMainNutriment(string $mainNutriment): void
    {
        $this->mainNutriment = $mainNutriment;
    }
    public function setMainMineral(string $mainMineral): void
    {
        $this->mainMineral = $mainMineral;
    }
}

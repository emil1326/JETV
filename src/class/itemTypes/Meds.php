<?php

class Meds extends Item
{
    private int $healthGain;
    private string $effect;
    private string $duration;
    private string $unwantedEffect;

    public function __construct(
        int $healthGain,
        string $effect,
        string $duration,
        string $unwantedEffect
    ) {
        $this->healthGain = $healthGain;
        $this->effect = $effect;
        $this->duration = $duration;
        $this->unwantedEffect = $unwantedEffect;
    }

    // SETTERS //
    public function getHealthGain(): string
    {
        return $this->healthGain;
    }
    public function getEffect(): string
    {
        return $this->effect;
    }
    public function getDuration(): string
    {
        return $this->duration;
    }
    public function getUnwantedEffect(): string
    {
        return $this->unwantedEffect;
    }

    // SETTERS //
    public function setHealthGain(int $healthGain): void
    {
        $this->healthGain = $healthGain;
    }
    public function setEffect(string $effect): void
    {
        $this->effect = $effect;
    }
    public function setDuration(string $duration): void
    {
        $this->duration = $duration;
    }
    public function setUnwantedEffect(string $unwantedEffect): void
    {
        $this->unwantedEffect = $unwantedEffect;
    }
}

<?php

class ItemFilter
{
    private array $itemTypes;
    private int $priceMin;
    private int|null $priceMax;
    private string|null $itemName;
    private int $starsMin;

    public function __construct(array $itemTypes, int $priceMin, int|null $priceMax, string|null $itemName, int $starsMin = 0)
    {
        $this->itemTypes = $itemTypes;
        $this->priceMin = $priceMin;
        $this->priceMax = $priceMax;
        $this->itemName = $itemName;
        $this->starsMin = $starsMin;
    }

    // GETTERS //
    public function getItemTypes(): null|array
    {
        return $this->itemTypes;
    }
    public function getPriceMin(): null|int
    {
        return $this->priceMin;
    }
    public function getPriceMax(): null|int
    {
        return $this->priceMax;
    }
    public function getItemName(): null|string
    {
        return $this->itemName;
    }
    public function getStarsMin(): null|int
    {
        return $this->starsMin;
    }

    // SETTERS //
    public function setItemTypes(array $itemTypes): void
    {
        $this->itemTypes = $itemTypes;
    }
    public function setPriceMin(int $price): void
    {
        $this->priceMin = $price;
    }
    public function setPriceMax(int|null $price): void
    {
        $this->priceMax = $price;
    }
    public function setItemName(string|null $name): void
    {
        $this->itemName = $name;
    }
    public function setStarsMin(int $starsMin): void
    {
        $this->starsMin = $starsMin;
    }
}

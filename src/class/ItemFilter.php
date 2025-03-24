<?php

enum ItemType
{
    case Weapon;
    case Armor;
    case Meds;
    case Food;
    case Ammo;
}

class ItemFilter
{
    private array $itemTypes;
    private int $priceMin;
    private int $priceMax;
    private string $itemName;
    private int $etoilesMin;

    public function __construct(array $itemTypes, int $priceMin, int $priceMax, string $itemName, int $etoilesMin)
    {
        $this->itemTypes = $itemTypes;
        $this->priceMin = $priceMin;
        $this->priceMax = $priceMax;
        $this->itemName = $itemName;
        $this->etoilesMin = $etoilesMin;
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
    public function getEtoilesMin(): null|int
    {
        return $this->etoilesMin;
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
    public function setPriceMax(int $price): void
    {
        $this->priceMax = $price;
    }
    public function setItemName(string $name): void
    {
        $this->itemName = $name;
    }
    public function setEtoilesMin(int $min): void
    {
        $this->etoilesMin = $min;
    }
}

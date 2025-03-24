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

    public function __construct(array $itemTypes, int $priceMin, int $priceMax)
    {
        $this->itemTypes = $itemTypes;
        $this->priceMin = $priceMin;
        $this->priceMax = $priceMax;
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

    // SETTERS //
    //  TODO: Write Setters & Complete Class
}

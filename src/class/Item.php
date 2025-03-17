<?php

require_once 'itemTypes/Ammo.php';
require_once 'itemTypes/Armor.php';
require_once 'itemTypes/Food.php';
require_once 'itemTypes/Meds.php';
require_once 'itemTypes/Weapon.php';

class Item
{
    private int $id;
    private string $type;
    private string $name;
    private string $description;
    private int $itemWeight;
    private int $buyPrice;
    private int $sellPrice;
    private string $imageLink;
    private int $utility;
    private int $itemStatus;

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
        int $itemStatus
    ) {
        $this->id = $id;
        $this->type = $type;
        $this->name = $name;
        $this->description = $description;
        $this->itemWeight = $itemWeight;
        $this->buyPrice = $buyPrice;
        $this->sellPrice = $sellPrice;
        $this->imageLink = $imageLink;
        $this->utility = $utility;
        $this->itemStatus = $itemStatus;
    }

    // GETTERS //
    public function getId(): int
    {
        return $this->id;
    }
    public function getType(): string
    {
        return $this->type;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getDescription(): string
    {
        return $this->description;
    }
    public function getItemWeight(): int
    {
        return $this->itemWeight;
    }
    public function getBuyPrice(): int
    {
        return $this->buyPrice;
    }
    public function getSellPrice(): int
    {
        return $this->sellPrice;
    }
    public function getImageLink(): string
    {
        return $this->imageLink;
    }
    public function getUtility(): int
    {
        return $this->utility;
    }
    public function getItemStatus(): int
    {
        return $this->itemStatus;
    }

    // SETTERS //
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function setDescription(string $description): void
    {
        $this->name = $description;
    }
    public function setItemWeight(string $itemWeight): void
    {
        $this->itemWeight = $itemWeight;
    }
    public function setBuyPrice(string $buyPrice): void
    {
        $this->buyPrice = $buyPrice;
    }
    public function setSellPrice(string $sellPrice): void
    {
        $this->sellPrice = $sellPrice;
    }
    public function setImageLink(string $imageLink): void
    {
        $this->imageLink = $imageLink;
    }
    public function setUtility(int $utility): void
    {
        $this->utility = $utility;
    }
    public function setItemStatus(int $itemStatus): void
    {
        $this->itemStatus = $itemStatus;
    }
}

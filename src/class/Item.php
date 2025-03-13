<?php

class Item 
{
    private int $id;
    private string $name;
    private string $description;
    private int $poidItem;
    private int $buyPrice;
    private int $sellPrice;
    private string $imagelink;
    private int $utiliter;
    private int $itemStatus;

    public function __construct(
        int $id,
        string $name,
        string $description,
        int $poidItem,
        int $buyPrice,
        int $sellPrice,
        string $imagelink,
        int $utiliter,
        int $itemStatus
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->$poidItem = $poidItem;
        $this->buyPrice = $buyPrice;
        $this->sellPrice = $sellPrice;
        $this->imagelink = $imagelink;
        $this->utiliter= $utiliter;
        $this->itemStatus= $itemStatus;
    }
        // GETTERS //
        public function getId(): int
        {
            return $this->id;
        }
        public function getName(): string
        {
            return $this->name;
        }
        public function getDescription(): string
        {
            return $this->description;
        }
        public function getPoidItem(): int
        {
            return $this->poidItem;
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
            return $this->imagelink;
        }
        public function getUtiliter(): int
        {
            return $this->utiliter;
        }
        public function getItemStatus(): int
        {
            return $this->itemStatus;
        }
    
        // SETTERS //
        public function setName(string $name)
        {
            $this->name = $name;
        }
        public function setDescription(string $description)
        {
            $this->name = $description;
        }
        public function setPoidItem(string $poidItem)
        {
            $this->poidItem = $poidItem;
        }
        public function setBuyPrice(string $buyPrice)
        {
            $this->buyPrice = $buyPrice;
        }
        public function setSellPrice(string $sellPrice)
        {
            $this->sellPrice = $sellPrice;
        }
        public function setImageLink(string $imagelink)
        {
            $this->imagelink = $imagelink;
        }
        public function setUtiliter(string $utiliter)
        {
            $this->utiliter = $utiliter;
        }
        public function setMaxWeight(string $itemStatus)
        {
            $this->itemStatus = $itemStatus;
        }
}
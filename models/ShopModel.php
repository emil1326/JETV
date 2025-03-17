<?php

require_once 'models/Model.php';

class ShopModel extends ItemModel
{
    public function __construct(protected PDO $pdo)
    {
        parent::__construct($pdo);
    }

    public function selectAll(): null|array
    {
        $items = [];

        try {
            $stm = $this->pdo->prepare('SELECT itemID, qt FROM shop');
            $stm->execute();

            $data = $stm->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($data)) {
                foreach ($data as $row) {
                    $items[] = [
                        'item' => parent::selectOneFromShop($row['itemID']),
                        'quantity' => $row['qt']
                    ];
                }

                return $items;
            }
            return null;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    public function selectFiltered(array $items, ItemFilter $filter): null|array
    {
        $filteredItems = [];

        foreach ($items as $item) {
            if (
                in_array($item->getType(), $filter->getItemTypes())
                && $item->getBuyPrice() >= $filter->getPriceMin()
                && $item->getBuyPrice() <= $filter->getPriceMax()
            ) {
                $filteredItems[] = $item;
            }
        }

        return $filteredItems;
    }
}

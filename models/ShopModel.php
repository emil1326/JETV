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

        $stm = $this->pdo->prepare('select * from shop inner join item on item.itemID = shop.itemID;');
        $stm->execute();

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($data)) {
            foreach ($data as $row) {
                $items[] = [
                    'item' => parent::makeItem($row, false),
                    'quantity' => $row['qt']
                ];
            }

            return $items;
        }
        return null;
    }

    public function selectOne(int $id): null|Item
    {
        $stm = $this->pdo->prepare('call GetOneShopItem(:id)');
        $stm->bindValue(':id', $id, PDO::PARAM_INT);
        $stm->execute();

        $data = $stm->fetch(PDO::FETCH_ASSOC);

        if (!empty($data)) {
            return parent::makeItem($data);
        }

        return null;
        try {
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }
}

<?php

require_once 'models/Model.php';

class InventoryModel extends ItemModel
{
    public function __construct(protected PDO $pdo)
    {
        parent::__construct($pdo);
    }

    public function selectAll(): null|array
    {
        $items = [];

        try {
            $stm = $this->pdo->prepare('SELECT itemID, qt FROM inventaire');
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
}

<?php

class ShopModel
{
    public function __construct(private PDO $pdo, private ItemModel $itemModel) {}

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
                        'item' => $this->itemModel->selectById($row['itemID']),
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

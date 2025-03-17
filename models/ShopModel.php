<?php

require_once 'models/Model.php';

class ShopModel extends Model
{
    public function __construct(protected PDO $pdo, private ItemModel $itemModel)
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

    /*
    public function selectFiltered(ItemFilter $filter): null|array
    {
        //
    }
    */
}

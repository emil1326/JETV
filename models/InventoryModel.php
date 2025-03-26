<?php

require_once 'models/ItemModel.php'; // requier ici au lieu de dedans le controller vu qui faut toujour le faire anyways
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
            $stm = $this->pdo->prepare('call GetAllInventoryItems()');
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
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    public function useITem(int $itemID, int $playerID): bool|null
    {
        try {
            $stm = $this->pdo->prepare('call UseItem( :itemID , :playerID )');
            $stm->bindValue(':itemID', $itemID, PDO::PARAM_INT);
            $stm->bindValue(':playerID', $playerID, PDO::PARAM_INT);
            $stm->execute();

            return true;
        } catch (PDOException $e) {
            return false;
            // throw new PDOException($e->getMessage(), $e->getCode());
        }
    }
}

<?php

require_once 'models/ItemModel.php'; // requier ici au lieu de dedans le controller vu qui faut toujour le faire anyways
require_once 'models/Model.php';

class InventoryModel extends ItemModel
{
    public function __construct(protected PDO $pdo)
    {
        parent::__construct($pdo);
    }

    public function selectAll(int $playerId): null|array
    {
        $items = [];

        try {
            $stm = $this->pdo->prepare('call GetAllInventoryItems(:playerId)');
            $stm->bindValue(':playerId', $playerId, PDO::PARAM_INT);
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

    public function selectOne(int $id, int $playerID): null|array
    {
        $stm = $this->pdo->prepare('call GetOneInventoryItem(:id , :playerID)');
        $stm->bindValue(':id', $id, PDO::PARAM_INT);
        $stm->bindValue(':playerID', $playerID, PDO::PARAM_INT);
        $stm->execute();

        $data = $stm->fetch(PDO::FETCH_ASSOC);

        if (!empty($data)) {
            return $item = [
                'item' => parent::makeItem($data),
                'quantity' => $data['qt']
            ];
        }

        return null;
    }

    public function totalWeight(int $playerId)
    {
        $itemsInv = $this->selectAll($playerId);
        $totalWeight = 0;
        if (!empty($itemsInv)) {
            foreach ($itemsInv as $itemV) {
                $totalWeight += $itemV['item']->getItemWeight() * $itemV['quantity'];
            }
        }
        return $totalWeight;
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
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }
}

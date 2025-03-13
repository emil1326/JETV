<?php

require_once 'src/class/Item.php';

class UserModel
{
    public function __construct(private PDO $pdo) {}

    public function selectById(int $id): null|Item
    {
        try {
            $stm = $this->pdo->prepare('SELECT id, name, description, poidItem, buyPrice, sellPrice, imagelink, utiliter, itemStatus FROM item WHERE itemID=:id');
            $stm->bindValue(':id', $id, PDO::PARAM_INT);
            $stm->execute();

            $data = $stm->fetch(PDO::FETCH_ASSOC);

            if (!empty($data)) {
                return new Item(
                    $id,
                    $data['name'],
                    $data['description'],
                    $data['poidItem'],
                    $data['buyPrice'],
                    $data['sellPrice'],
                    $data['imagelink'],
                    $data['utiliter'],
                    $data['itemStatus']
                );
            }

            return null;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    public function createItem(string $name, string $description, int $poidItem, int $buyPrice, int $sellPrice, string $imagelink, int $utiliter, int $itemStatus)
    {
        $stm = $this->pdo->prepare('CALL CreateItem(?, ?, ?, ?, ?, ?, ?, ?)');
        $stm->execute([$name, $description, $poidItem, $buyPrice, $sellPrice, $imagelink, $utiliter, $itemStatus]);
        try {
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }
}
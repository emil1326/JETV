<?php

require_once 'models/Model.php';
require_once 'src/class/Item.php';

class ItemModel extends Model
{
    public function __construct(protected PDO $pdo)
    {
        parent::__construct($pdo);
    }

    public function getPDO(): PDO
    {
        return $this->pdo;
    }

    public function selectById(int $id): null|Item
    {
        try {
            $stm = $this->pdo->prepare('SELECT itemID, itemName, description, poidItem, buyPrice, sellPrice, imageLink, utiliter, itemStatus FROM item WHERE itemID=:id');
            $stm->bindValue(':id', $id, PDO::PARAM_INT);
            $stm->execute();

            $data = $stm->fetch(PDO::FETCH_ASSOC);

            if (!empty($data)) {
                return new Item(
                    $id,
                    $data['itemName'],
                    $data['description'],
                    $data['poidItem'],
                    $data['buyPrice'],
                    $data['sellPrice'],
                    $data['imageLink'],
                    $data['utiliter'],
                    $data['itemStatus']
                );
            }

            return null;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    //  TODO: TEST
    public function selectAll(): null|array
    {
        $items = [];

        try {
            $stm = $this->pdo->prepare('SELECT * FROM item');
            $stm->execute();

            $data = $stm->fetchAll(PDO::FETCH_ASSOC);

            if (! empty($data)) {
                foreach ($data as $row) {
                    $items[] = new Item(
                        $row['id'],
                        $row['name'],
                        $row['description'],
                        $row['itemWeight'],
                        $row['buyPrice'],
                        $row['sellPrice'],
                        $row['imageLink'],
                        $row['utility'],
                        $row['itemStatus'],
                    );
                }

                return $items;
            }
            return null;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    //  TODO: TEST
    public function selectByUserId(int $joueureID): null|array
    {
        $items = [];
        try {
            $stm = $this->pdo->prepare('SELECT * FROM inventaire WHERE joueureID=:joueureID');
            $stm->bindValue(":joueureID", $joueureID, PDO::PARAM_INT);

            $stm->execute();
            $data = $stm->fetchAll(PDO::FETCH_ASSOC);

            if (! empty($data)) {
                foreach ($data as $row) {
                    $items[] = new Item(
                        $row['id'],
                        $row['name'],
                        $row['description'],
                        $row['itemWeight'],
                        $row['buyPrice'],
                        $row['sellPrice'],
                        $row['imageLink'],
                        $row['utility'],
                        $row['itemStatus'],
                    );
                }

                return $items;
            }

            return null;
        } catch (PDOException $e) {

            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }
}

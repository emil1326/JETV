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

    // shop

    public function selectOneFromShop(int $id): null|Item
    {
        try {
            $stm = $this->pdo->prepare('call GetOneShopItem(:id)');
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

    public function selectAllFromShop(): null|array
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

    //  cart
    public function selectOneByPlayerIdFromCart(int $itemID, int $joueureID): null|Item
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

    public function selectAllByPlayerIdFromCart(int $joueureID): null|array
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

    //  Inventory
    public function selectOneByPlayerIdFromInventory(int $itemID, int $joueureID): null|Item
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

    public function selectAllByPlayerIdFromInventory(int $joueureID): null|array
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

    private function makeItem($itemInfo): Item|null
    {
        $objc = null;

        switch ($itemInfo['typeItem']){
            case 'arme':
                $objc = new Weapon(
                    $row['id'],
                    $row['name'],
                    $row['description'],
                    $row['']

                );
                break;
            case 'armure':
                //ok
                break;
            case 'med':
                //ok
                break;
            case 'food':
                //ok
                break;
            case 'mun':
                //ok
                break;
            case null:
                //err
                break;
        }

        return null;
    }
}

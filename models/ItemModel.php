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
                return $this->makeItem($data);
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
            $stm = $this->pdo->prepare('call GetAllShopItem()');
            $stm->execute();

            $data = $stm->fetchAll(PDO::FETCH_ASSOC);

            if (! empty($data)) {
                foreach ($data as $row) {
                    $items[] = $this->makeItem($row);
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
        $items = null;
        try {
            $stm = $this->pdo->prepare('call GetOneCartItem( :id , :joueureID)');
            $stm->bindValue(':id', $itemID, PDO::PARAM_INT);
            $stm->bindValue(":joueureID", $joueureID, PDO::PARAM_INT);

            $stm->execute();
            $data = $stm->fetchAll(PDO::FETCH_ASSOC);

            if (! empty($data)) {
                return $this->makeItem($data);
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
            $stm = $this->pdo->prepare('call GetAllCartItems( :joueureID )');
            $stm->bindValue(":joueureID", $joueureID, PDO::PARAM_INT);

            $stm->execute();
            $data = $stm->fetchAll(PDO::FETCH_ASSOC);

            if (! empty($data)) {
                foreach ($data as $row) {
                    $items[] = $this->makeItem($row);
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
            $stm = $this->pdo->prepare('call GetOneInventoryItem( :id , :joueureID )');
            $stm->bindValue(':id', $itemID, PDO::PARAM_INT);
            $stm->bindValue(":joueureID", $joueureID, PDO::PARAM_INT);

            $stm->execute();
            $data = $stm->fetchAll(PDO::FETCH_ASSOC);

            if (! empty($data)) {
                return   $this->makeItem($data);
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
            $stm = $this->pdo->prepare('call GetAllInventoryItems( :joueureID )');
            $stm->bindValue(":joueureID", $joueureID, PDO::PARAM_INT);

            $stm->execute();
            $data = $stm->fetchAll(PDO::FETCH_ASSOC);

            if (! empty($data)) {
                foreach ($data as $row) {
                    $items[] = $this->makeItem($row);
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

        switch ($itemInfo['typeItem']) {
            case 'arme':
                $objc = new Weapon(
                    $itemInfo['itemID'],
                    $itemInfo['typeItem'],
                    $itemInfo['itemName'],
                    $itemInfo['description'],
                    $itemInfo['poidItem'],
                    $itemInfo['buyPrice'],
                    $itemInfo['sellPrice'],
                    $itemInfo['imageLink'],
                    $itemInfo['utiliter'],
                    $itemInfo['itemStatus'],
                    $itemInfo['efficiency'],
                    $itemInfo['genre'],
                    $itemInfo['calibre']
                );
                break;
            case 'armure':
                $objc = new Armor(
                    $itemInfo['itemID'],
                    $itemInfo['typeItem'],
                    $itemInfo['itemName'],
                    $itemInfo['description'],
                    $itemInfo['poidItem'],
                    $itemInfo['buyPrice'],
                    $itemInfo['sellPrice'],
                    $itemInfo['imageLink'],
                    $itemInfo['utiliter'],
                    $itemInfo['itemStatus'],
                    $itemInfo['material'],
                    $itemInfo['size']
                );
                break;
            case 'med':
                $objc = new Meds(
                    $itemInfo['itemID'],
                    $itemInfo['typeItem'],
                    $itemInfo['itemName'],
                    $itemInfo['description'],
                    $itemInfo['poidItem'],
                    $itemInfo['buyPrice'],
                    $itemInfo['sellPrice'],
                    $itemInfo['imageLink'],
                    $itemInfo['utiliter'],
                    $itemInfo['itemStatus'],
                    $itemInfo['healthGain'],
                    $itemInfo['effect'],
                    $itemInfo['duration'],
                    $itemInfo['unwantedEffect']
                );
                break;
            case 'food':
                $objc = new Food(
                    $itemInfo['itemID'],
                    $itemInfo['typeItem'],
                    $itemInfo['itemName'],
                    $itemInfo['description'],
                    $itemInfo['poidItem'],
                    $itemInfo['buyPrice'],
                    $itemInfo['sellPrice'],
                    $itemInfo['imageLink'],
                    $itemInfo['utiliter'],
                    $itemInfo['itemStatus'],
                    $itemInfo['healthGain'],
                    $itemInfo['apportCalorique'],
                    $itemInfo['composantNutritivePrincipale'],
                    $itemInfo['mineralPrincipale']
                );
                break;
            case 'mun':
                $objc = new Ammo(
                    $itemInfo['itemID'],
                    $itemInfo['typeItem'],
                    $itemInfo['itemName'],
                    $itemInfo['description'],
                    $itemInfo['poidItem'],
                    $itemInfo['buyPrice'],
                    $itemInfo['sellPrice'],
                    $itemInfo['imageLink'],
                    $itemInfo['utiliter'],
                    $itemInfo['itemStatus'],
                    $itemInfo['calibre']
                );
                break;
            case null:
                //err
                break;
        }

        return $objc;
    }
}

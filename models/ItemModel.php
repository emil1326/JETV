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

    //  cart
    public function selectOneByPlayerIdFromCart(int $itemID, int $joueureID): null|Item
    {
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
        // try {
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
        // } catch (PDOException $e) {

        // throw new PDOException($e->getMessage(), $e->getCode());
        // }
    }

    //  Inventory
    public function selectOneByPlayerIdFromInventory(int $itemID, int $joueureID): null|Item
    {
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

    public function selectFiltered(array $items, ItemFilter $filter): null|array
    {
        $filteredItems = [];

        foreach ($items as $item) {
            // $item => ['item' => [], 'quantity' => '']
            $quantity = $item['quantity'];
            $item = $item['item'];

            if (
                (count($filter->getItemTypes()) == 0 || in_array($item->gettype(), $filter->getItemtypes()))
                && $item->getBuyPrice() >= $filter->getPriceMin()
                && ($filter->getPriceMax() == 0 || $item->getBuyPrice() <= $filter->getPriceMax())
                && ($filter->getStarsMin() == null || $item->getStarsMin() >= $filter->getStarsMin()) // wont work
                && ($filter->getItemName() == null || str_contains(strtolower($item->getName()), strtolower($filter->getItemName())))
            ) {
                $filteredItems[] = ['item' => $item, 'quantity' => $quantity];
            }
        }

        return $filteredItems;
    }

    public function selectOrdered(array $items, string $sortType): array
    {
        switch ($sortType) {
            case 'price':
                function price_cmp($a, $b): int
                {
                    return $a['item']->getBuyPrice() < $b['item']->getBuyPrice() ? -1 : 1;
                }
                usort($items, 'price_cmp');
                break;
            case 'utility':
                function utility_cmp($a, $b): int
                {
                    return $a['item']->getUtility() < $b['item']->getUtility() ? -1 : 1;
                }
                usort($items, 'utility_cmp');
                break;
            case 'weight':
                function weight_cmp($a, $b): int
                {
                    return $a['item']->getItemWeight() < $b['item']->getItemWeight() ? -1 : 1;
                }
                usort($items, 'weight_cmp');
                break;
            case 'quantity':
                function quantity_cmp($a, $b): int
                {
                    return $a['quantity'] < $b['quantity'] ? -1 : 1;
                }
                usort($items, 'quantity_cmp');
                break;
        }

        return $items;
    }

    protected function makeItem(array $itemInfo, bool $allData = true): null|Item|Weapon|Armor|Meds|Food|Ammo
    {
        $objc = null;
        $infos = [
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
        ];

        if (!$allData)
            $itemInfo['typeItem'] = null; // force dedans unitem regulier sans details

        switch ($itemInfo['typeItem']) {
            case 'arme':
                array_push(
                    $infos,
                    $itemInfo['efficiency'],
                    $itemInfo['genre'],
                    $itemInfo['calibre']
                );
                $objc = new Weapon(...$infos,);
                break;
            case 'armure':
                array_push(
                    $infos,
                    $itemInfo['material'],
                    $itemInfo['size'],
                );
                $objc = new Armor(...$infos);
                break;
            case 'med':
                array_push(
                    $infos,
                    $itemInfo['healthGain'],
                    $itemInfo['effect'],
                    $itemInfo['duration'],
                    $itemInfo['unwantedEffect'],
                );
                $objc = new Meds(...$infos);
                break;
            case 'food':
                array_push(
                    $infos,
                    $itemInfo['healthGain'],
                    $itemInfo['apportCalorique'],
                    $itemInfo['composantNutritivePrincipale'],
                    $itemInfo['mineralPrincipale'],
                );
                $objc = new Food(...$infos);
                break;
            case 'mun':
                array_push(
                    $infos,
                    $itemInfo['calibre'],
                );
                $objc = new Ammo(...$infos);
                break;
            case null:
                $objc = new Item(...$infos);
                break;
        }

        return $objc;
    }
}

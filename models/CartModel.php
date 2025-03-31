<?php

require_once 'models/ItemModel.php'; // requier ici au lieu de dedans le controller vu qui faut toujour le faire anyways
require_once 'models/Model.php';

class CartModel extends ItemModel
{
    public function __construct(protected PDO $pdo)
    {
        parent::__construct($pdo);
    }

    public function selectAll($playerID): null|array
    {
        $items = [];

        try {
            $stm = $this->pdo->prepare('call GetAllCartItems(:playerID)');
            $stm->bindValue(':playerID', $playerID, PDO::PARAM_INT);
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

    public function buyCart(int $playerID): bool
    {
        try {
            $stm = $this->pdo->prepare('call PassCommande(:playerID)');
            $stm->bindValue(':playerID', $playerID, PDO::PARAM_INT);
            $stm->execute();

            $data = $stm->fetchAll(PDO::FETCH_ASSOC);

            return true;
        } catch (PDOException $e) {
            return false;
            throw new PDOException($e->getMessage(), $e->getCode()); // turn around if not debug
        }
    }

    public function addItemToCart(int $playerID, int $itemID): void
    {
        // 
        try {
            $stm = $this->pdo->prepare('call PassCommande(:playerID)');
            $stm->bindValue(':playerID', $playerID, PDO::PARAM_INT);
            $stm->execute();

            $data = $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode()); // turn around if not debug
        }
        echo 'added item' . $playerID . $itemID;
    }
    public function removeItemFormCart(int $playerID, int $itemID): void
    {
        // 
        echo 'removed item' . $playerID . $itemID;
    }
    public function clearCart(int $playerID): void
    {
        //         
        echo 'clear cart' . $playerID;
    }
}

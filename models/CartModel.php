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
                        'item' => parent::makeItem($row[], false),
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
            // throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

    public function addItemToCart(int $playerID, int $itemID, int $quantity): bool
    {
        try {
            $stm = $this->pdo->prepare("CALL AddItemToCart(:userID, :itemID, :quantity)");
            $stm->bindValue(':userID', $playerID, PDO::PARAM_INT); // Assuming userID is stored in session
            $stm->bindValue(':itemID', $itemID, PDO::PARAM_INT);
            $stm->bindValue(':quantity', $quantity, PDO::PARAM_INT);
            $stm->execute();

            return true;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }
    public function removeItemFromCart(int $playerID, int $itemID): void
    {
        try {
            $stm = $this->pdo->prepare("CALL RemoveItemFromCart(:userID, :itemID)");
            $stm->bindValue(':userID', $playerID, PDO::PARAM_INT); // Assuming userID is stored in session
            $stm->bindValue(':itemID', $itemID, PDO::PARAM_INT);
            $stm->execute();
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }
    public function clearCart(int $playerID): void
    {
        try {
            $stm = $this->pdo->prepare("CALL ClearCart(:userID)");
            $stm->bindValue(':userID', $playerID, PDO::PARAM_INT); // Assuming userID is stored in session
            $stm->execute();
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }
}

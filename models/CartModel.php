<?php

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
}

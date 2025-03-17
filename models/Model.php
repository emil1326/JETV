<?php

class Model
{
    public function __construct(protected PDO $pdo) {}

    public function isProcedureTrue(string $statement, array $parameters): bool
    {
        try {
            $stm = $this->pdo->prepare($statement);
            $stm->execute($parameters);

            $result = $stm->fetch(PDO::FETCH_ASSOC);

            return $result == 1 ? true : false;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }
}

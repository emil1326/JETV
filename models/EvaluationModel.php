<?php

require_once 'models/Model.php';
require_once 'src/class/Evaluation.php';

class EvaluationModel extends Model
{
    public function __construct(protected PDO $pdo)
    {
        parent::__construct($pdo);
    }

    public function selectAllByIdItem(int $id): null|Comment
    {
        # todo fix this, pas utuliser les bonnes choses => foreach line, get comment, pas par user, pour evals use procedure
        try {

            // Garder seulement la bonne version selon [procédure / fonction]

            // 1.
            $stm = $this->pdo->prepare('call GET_ITEM_SQL_PROCEDURE_HERE(?)');
            $stm->execute([$id]);

            // 2.
            $stm = $this->pdo->prepare('call GET_ITEM_SQL_PROCEDURE_HERE(:id)');
            $stm->bindValue(':id', $id, PDO::PARAM_INT);
            $stm->execute();

            $data = $stm->fetch(PDO::FETCH_ASSOC);

            if (!empty($data)) {
                return new Comment(
                    $data['itemID'],
                    $data['joueureID'],
                    $id,
                    $data['commentaire'],
                );
            }

            return null;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }
}

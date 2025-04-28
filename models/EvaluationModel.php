<?php

require_once 'models/Model.php';
require_once 'src/class/Evaluation.php';

class EvaluationModel extends Model
{
    public function __construct(protected PDO $pdo)
    {
        parent::__construct($pdo);
    }

    public function selectAvergeEval(int $itemID): null|Comment
    {
        try {
            $stm = $this->pdo->prepare('call GetAverageEvaluation(:id)');
            $stm->bindValue(':id', $itemID, PDO::PARAM_INT);
            $stm->execute();

            $data = $stm->fetch(PDO::FETCH_ASSOC);

            if (!empty($data)) {
                return new Comment(
                    $data['itemID'],
                    $data['joueureID'],
                    $itemID,
                    $data['commentaire'],
                );
            }

            return null;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }
}

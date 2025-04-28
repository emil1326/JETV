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
            #$stm = $this->pdo->prepare('call setCaps(?, ?)');
            #$stm->execute([$caps, $playerID]);

            $stm = $this->pdo->prepare('call ');
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

<?php

require_once 'models/Model.php';
require_once 'src/class/Comment.php';

class CommentModel extends Model
{
    public function __construct(protected PDO $pdo)
    {
        parent::__construct($pdo);
    }

    public function selectById(int $id): null|Comment
    {
        try {
            $stm = $this->pdo->prepare('SELECT itemID, joueureID, commentaireID, commentaire, evaluations FROM commentaires WHERE commentaireID=:id');
            $stm->bindValue(':id', $id, PDO::PARAM_INT);
            $stm->execute();

            $data = $stm->fetch(PDO::FETCH_ASSOC);

            if (!empty($data)) {
                return new Comment(
                    $data['itemID'],
                    $data['joueureID'],
                    $id,
                    $data['commentaire'],
                    $data['evaluations'],
                );
            }

            return null;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }
}

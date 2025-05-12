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
        throw new Exception("do not use select by here?");


        # todo fix this, pas utuliser les bonnes choses => foreach line, get comment, pas par user, pour evals use procedure
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
    public function selectAllByItemId(int $itemID): null|array
    {
        try {
            $stm = $this->pdo->prepare('call GetAllCommentaires(:id)');
            $stm->bindValue(':id', $itemID, PDO::PARAM_INT);
            $stm->execute();

            $data = $stm->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($data)) {
                foreach ($data as $row) {
                    $items[] = new Comment(
                        $row['commentaireID'],
                        $row['joueureID'],
                        $itemID,
                        $row['commentaire'],
                        $row['evaluations'],
                    );
                }
                return $items;
            }

            return null;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }
    public function addComment(int $itemID, int $joueureID, string $commentaire, int $evals): bool
    {
        try {
            $stm = $this->pdo->prepare('INSERT INTO commentaires (itemID, joueureID, commentaire, evaluations) VALUES (:itemID, :joueureID, :commentaire, :evaluations)');
            $stm->bindValue(':itemID', $itemID, PDO::PARAM_INT);
            $stm->bindValue(':joueureID', $joueureID, PDO::PARAM_INT);
            $stm->bindValue(':commentaire', $commentaire, PDO::PARAM_STR);
            $stm->bindValue(':evaluations', $evals, PDO::PARAM_INT);
            return $stm->execute();
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }
    }

}

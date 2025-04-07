<?php

require_once 'models/Model.php';
require_once 'src/class/Answer.php';

class AnswerModel extends Model
{
    public function __construct(protected PDO $pdo)
    {
        parent::__construct($pdo);
    }

    public function selectAll(): null|array
    {
        $stm = $this->pdo->prepare('SELECT * FROM reponsesQuetes;');
        $stm->execute();

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($data)) {
            return array_map(fn($row) => new Answer(
                $row['answerID'],
                $row['questID'],
                $row['reponse'],
                $row['flagEstVraie']),
                $data);
        }
        return null;
    }
    public function selectByQuestId(int $id): null|array
    {
        $stm = $this->pdo->prepare('SELECT * FROM reponsesQuetes WHERE questID = :id;');
        $stm->bindValue(':id', $id, PDO::PARAM_INT);
        $stm->execute();

        $data = $stm->fetch(PDO::FETCH_ASSOC);

        if (!empty($data)) {
            return array_map(fn($row) => new Answer(
                $row['answerID'],
                $row['questID'],
                $row['reponse'],
                $row['flagEstVraie']),
                $data);
        }
        return null;
    }
}
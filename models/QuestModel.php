<?php

require_once 'models/Model.php';
require_once 'src/class/Quest.php';

class QuestModel extends Model
{
    public function __construct(protected PDO $pdo)
    {
        parent::__construct($pdo);
    }

    public function selectAll(): null|array
    {
        $stm = $this->pdo->prepare('call GetAllQuestionsAndAwnser()');
        $stm->execute();

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($data)) {
            return array_map(
                fn($row) => new Quest(
                    $row['questID'],
                    $row['question'],
                    0,
                    $row['difficultyName'],
                    $row['pvLoss'],
                ),
                $data
            );
        }
        return null;
    }
    public function selectById(int $id): null|Quest
    {
        $stm = $this->pdo->prepare('call GetOneQuestionByID(:id)');
        $stm->bindValue(':id', $id, PDO::PARAM_INT);
        $stm->execute();

        $data = $stm->fetch(PDO::FETCH_ASSOC);

        if (!empty($data)) {
            return new Quest(
                $data['questID'],
                $data['question'],
                // $data['diffID'],
                0,
                $data['difficultyName'],
                $data['pvLoss']
            );
        }
        return null;
    }
    public function selectByDifficulty(int $difficulty): null|array
    {
        $stm = $this->pdo->prepare('call GetOneRandomQuestionByDifficulty(:difficulty)');
        $stm->bindValue(':difficulty', $difficulty, PDO::PARAM_INT);
        $stm->execute();

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($data)) {
            return array_map(fn($row) => new Quest(
                $row['questID'],
                $row['question'],
                0,
                // $row['diffID'],
                $row['difficultyName'],
                $row['pvLoss']
            ), $data);
        }
        return null;
    }
    public function GetOneQuestionAndAwnserByID(int $difficulty): null|Quest
    {
        $stm = $this->pdo->prepare('call GetOneQuestionAndAwnserByID(:difficulty)');
        $stm->bindValue(':difficulty', $difficulty, PDO::PARAM_INT);
        $stm->execute();

        $data = $stm->fetch(PDO::FETCH_ASSOC);

        // returns 4 row avc toute les reponses todo mod

        if (!empty($data)) {
            return new Quest(
                $data['questID'],
                $data['question'],
                0,
                $data['difficultyName'],
                $data['pvLoss'],
            );
        }
        return null;
    }
}

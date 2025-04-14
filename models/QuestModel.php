<?php

require_once 'models/Model.php';
require_once 'src/class/Quest.php';
require_once 'src/class/Answer.php';

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
            $row = $data[0];
            return new Quest(
                $row['questID'],
                $row['question'],
                0,
                $row['difficultyName'],
                $row['pvLoss'],
            );
        }
        return null;
    }
    public function GetOneRandomQuestionByDifficulty(int $difficulty): null|Quest
    {
        $stm = $this->pdo->prepare('call GetOneRandomQuestionByDifficulty(:difficulty)');
        $stm->bindValue(':difficulty', $difficulty, PDO::PARAM_INT);
        $stm->execute();

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($data)) {
            $row = $data[0];
            return new Quest(
                $row['questID'],
                $row['question'],
                0,
                $row['difficultyName'],
                $row['pvLoss'],
            );
        }
        return null;
    }
    public function GetOneRandomQuestionByDifficultyOrLastDone(int $difficulty, int $playerID): null|Quest
    {
        $stm = $this->pdo->prepare('call GetOneRandomQuestionByDifficultyOrLastDone(:difficulty, :playerID)');
        $stm->bindValue(':difficulty', $difficulty, PDO::PARAM_INT);
        $stm->bindValue(':playerID', $playerID, PDO::PARAM_INT);
        $stm->execute();

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($data)) {
            $row = $data[0];
            return new Quest(
                $row['questID'],
                $row['question'],
                0,
                $row['difficultyName'],
                $row['pvLoss'],
            );
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
            $row = $data[0];
            return new Quest(
                $row['questID'],
                $row['question'],
                0,
                $row['difficultyName'],
                $row['pvLoss'],
            );
        }
        return null;
    }
    public function GetAnswersByQuestionId(int $id)
    {
        $stm = $this->pdo->prepare('call GetOneQuestionAndAwnserByID(:id)');
        $stm->bindValue(':id', $id, PDO::PARAM_INT);
        $stm->execute();

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($data)) {
            $answers = [];
            foreach ($data as $row) {
                $answers[] = new Answer(
                    $row['questID'],
                    $row['reponse'],
                    $row['flagEstVrai'],
                    $row['awnserID'],
                );
            }

            return $answers;
        }
        return null;
    }
    public function DoQuest(int $questID, int $playerID, int $answerID): int|null
    {
        $stm = $this->pdo->prepare('select DoQuest(:questID, :playerID, :answerID)');
        $stm->bindValue(':questID', $questID, PDO::PARAM_INT);
        $stm->bindValue(':playerID', $playerID, PDO::PARAM_INT);
        $stm->bindValue(':answerID', $answerID, PDO::PARAM_INT);
        $stm->execute();

        $data = $stm->fetchAll(PDO::FETCH_NUM);

        if (!empty($data)) {
            return $data[0][0];
        }
        return null;
    }
}

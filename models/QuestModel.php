<?php

require_once 'models/Model.php';
require_once 'src/class/Quest.php';

class Quest extends Model
{
    public function __construct(protected PDO $pdo)
    {
        parent::__construct($pdo);
    }

    public function selectAll(): null|array
    {
        $stm = $this->pdo->prepare('SELECT * FROM listeQuetes;');
        $stm->execute();

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($data)) {
            return array_map(
                fn($row) => new Quest(
                    $row['quest_id'],
                    $row['question'],
                    $row['difficulte_id'],
                    $row['difficulte']
                ),
                $data
            );
        }
        return null;
    }
    public function selectById(int $id): null|Quest
    {
        $stm = $this->pdo->prepare('SELECT * FROM listeQuetes WHERE quest_id = :id;');
        $stm->bindValue(':id', $id, PDO::PARAM_INT);
        $stm->execute();

        $data = $stm->fetch(PDO::FETCH_ASSOC);

        if (!empty($data)) {
            return new Quest(
                $data['quest_id'],
                $data['question'],
                $data['difficulte_id'],
                $data['difficulte']
            );
        }
        return null;
    }
    public function selectByDifficulty(int $difficulty): null|array
    {
        $stm = $this->pdo->prepare('SELECT * FROM listeQuetes WHERE difficulte_id = :difficulty;');
        $stm->bindValue(':difficulty', $difficulty, PDO::PARAM_INT);
        $stm->execute();

        $data = $stm->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($data)) {
            return array_map(fn($row) => new Quest(
                $row['quest_id'],
                $row['question'],
                $row['difficulte_id'],
                $row['difficulte']
            ), $data);
        }
        return null;
    }
    public function selectRandom(int $difficulty): null|Quest
    {
        $stm = $this->pdo->prepare('SELECT * FROM listeQuetes WHERE difficulte_id = :difficulty ORDER BY RAND() LIMIT 1;');
        $stm->bindValue(':difficulty', $difficulty, PDO::PARAM_INT);
        $stm->execute();

        $data = $stm->fetch(PDO::FETCH_ASSOC);

        if (!empty($data)) {
            return new Quest(
                $data['quest_id'],
                $data['difficulte_id'],
                $data['difficulte'],
                $data['reponse']
            );
        }
        return null;
    }
}


<?php

if (!isAuthenticated()) {
    echo 'DEV log: You are not logged in. You shouldn\'t be able to see this';
    //redirect('/');
}

$enigmaActif = true; // pour le header, savoir quoi highlight

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET) && isset($_GET['difficulty'])) {
    require 'models/QuestModel.php';

    $pdo = Database::getInstance()->getPDO();
    $model = new QuestModel($pdo);

    $difficulty = (int)$_GET['difficulty'];

    $quest = $model->GetOneRandomQuestionByDifficultyOrLastDone($difficulty, $_SESSION['playerID']);
    $answers = $model->GetAnswersByQuestionId($quest->getId());
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST) && isset($_POST['answer'])) {
    require 'models/QuestModel.php';

    $pdo = Database::getInstance()->getPDO();
    $model = new QuestModel($pdo);

    if (isset($_POST['option'])) {

        $res = $model->DoQuest($_POST['questID'], $_SESSION['playerID'], $_POST['option']);

        if ($res)
            redirect('/enigma');
        else {
            echo 'not pass';
            $didNotPassQuestion = true;
            $doNotRefresh = true;
        }
    } else {
        $noQuestionChoosed = true;
        $doNotRefresh = true;
    }
}

require 'views/enigmaQuestion.php';

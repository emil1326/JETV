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

    $quest = $model->selectByDifficulty($difficulty);

    // temp
    var_dump($quest);
}

$_POST['key'] = 0;



require 'views/enigmaQuestion.php';

<?php

require 'models/QuestModel.php';


if (!isAuthenticated()) {
    echo 'DEV log: You are not logged in. You shouldn\'t be able to see this';
    //redirect('/');
}


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET) && isset($_GET['difficulty'])) {
    $pdo = Database::getInstance()->getPDO();
    $model = new QuestModel($pdo);

    $difficulty = (int)$_GET['difficulty'];

    $quest = $model->selectByDifficulty($difficulty);

    // temp
    var_dump($quest);
}


$enigmaActif = true; // pour le header, savoir quoi highlight

require 'views/enigma.php';

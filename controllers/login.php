<?php

require 'src/class/Database.php';
require 'src/session.php';
require 'models/UserModel.php';

// Ne peux pas accéder à la page si déjà connecté
if (isAuthenticated()) {
    echo 'DEV log: You are already logged in. You shouldn\'t be able to see this';
    //redirect('/');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $pdo = Database::getInstance()->getPDO();
    $userModel = new UserModel($pdo);

    $id = $userModel->authentify($username, $password);

    if ($id != -1) {
        sessionStart();
        $_SESSION['playerID'] = $id;

        redirect('/');
    } else {
        $messageKey = '<div class="alert alert-danger">Échec de connexion: l\'alias et/ou le mot de passe sont invalide</div>';
    }
}

require 'views/login.php';

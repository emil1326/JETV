<?php
//ne peux pas acceder si deja connecter
/*if (isAuthenticated()) {
    redirect('/');
}*/

require 'src/class/Database.php';
require 'src/session.php';
require 'models/UserModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $db = Database::getInstance();
    $pdo = $db->getPDO();

    $userModel = new UserModel($pdo);

    $id = $userModel->authentify($username, $password);

    if ($id != -1) {
        sessionStart();

        //  TODO: Set ID in Session

        redirect('/');
    }

    $messageKey = '<div class="alert alert-danger">Connexion impossible</div>';
}

require 'views/login.php';

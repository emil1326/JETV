<?php

// Ne peux pas accéder à la page si déjà connecté
if (isAuthenticated()) {
    echo 'DEV log: You are already logged in. You shouldn\'t be able to see this';
    redirect('/');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $pdo = Database::getInstance()->getPDO();
    $userModel = new UserModel($pdo);

    $id = $userModel->authentify($username, $password);

    if (emptyFields($username, $password)) {
        $messageKey = '<div class="alert alert-danger">Tous les renseignements doivent être remplis</div>';
    } else if ($id == -1) {
        $messageKey = '<div class="alert alert-danger">Échec de connexion: l\'alias et/ou le mot de passe sont invalide
        <a type="button" href="/signup" class="btn btn-secondary">Sign UP</a>
        </div>';
        $doNotRefresh = true;
    } else {
        sessionStart();
        $_SESSION['playerID'] = $id;

        redirect('/');
    }
}

require 'views/login.php';

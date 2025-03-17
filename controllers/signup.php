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
    $firstName = $_POST['firstName'] ?? '';
    $lastName = $_POST['lastName'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $passwordConfirm = $_POST['passwordConfirm'] ?? '';

    $pdo = Database::getInstance()->getPDO();
    $userModel = new UserModel($pdo);

    // Check for empty fields
    if (emptyFields($firstName, $lastName, $username, $password, $passwordConfirm)) {
        $messageKey = '<div class="alert alert-danger">Tous les renseignements doivent être remplis</div>';
    } else if (strlen($password) < 8) {
        $messageKey = '<div class="alert alert-danger">Le mot de passe dois être au moins 8 caractères</div>';
    } else if ($password != $passwordConfirm) {
        $messageKey = '<div class="alert alert-danger">Les deux mots de passe ne sont pas identiques</div>';
    } else if (!$userModel->isUsernameAvailable($username)) {
        $messageKey = '<div class="alert alert-danger">Cet alias est déjà pris</div>';
    } else {
        $userModel->createUser($username, $firstName, $lastName, $password);
        header("Location: /login");
    }
}

require 'views/signup.php';

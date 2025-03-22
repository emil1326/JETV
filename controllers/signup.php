<?php

require 'src/class/Database.php';

// Ne peux pas accéder à la page si déjà connecté
if (isAuthenticated()) {
    echo 'DEV log: You are already logged in. You shouldn\'t be able to see this';
    redirect('/');
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
        $messageKey = displayError('Tous les renseignements doivent être remplis');
    } else if (strlen($password) < 8) {
        $messageKey = displayError('Le mot de passe dois être au moins 8 caractères');
    } else if ($password != $passwordConfirm) {
        $messageKey = displayError('Les deux mots de passe ne sont pas identiques');
    } else if (!$userModel->isUsernameAvailable($username)) {
        $messageKey = displayError('Cet alias est déjà pris');
    } else {
        $userModel->createUser($username, $firstName, $lastName, $password);
        header("Location: /login");
    }
}

require 'views/signup.php';

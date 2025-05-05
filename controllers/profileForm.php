<?php
if (!isAuthenticated()) {
    echo 'DEV log: You are not logged in. You shouldn\'t be able to see this';
    redirect('/');
}
$pdo = Database::getInstance()->getPDO();
$model = new UserModel($pdo);
$user= $model->selectById($_SESSION['playerID']);
$firstName = $_POST['firstName'] ?? $user->getFirstName();
$lastName = $_POST['lastName'] ?? $user->getLastName();
$username = $_POST['username'] ?? $user->getUsername();
$password = $_POST['password'] ?? '';
$passwordConfirm = $_POST['passwordConfirm'] ?? '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $pdo = Database::getInstance()->getPDO();
    $userModel = new UserModel($pdo);

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
    }
    // Check for empty fields
    if (emptyFields($firstName, $lastName, $username)) {
        $messageKey = 'Tous les renseignements doivent être remplis';
    } else if (strlen($password) < 8 && strlen($password) > 0) {
        $messageKey = 'Le mot de passe dois être au moins 8 caractères';
    } else if ($password != $passwordConfirm) {
        $messageKey = 'Les deux mots de passe ne sont pas identiques';
    } else if (!$userModel->isUsernameAvailable($username) && $username != $user->getUsername()) {
        $messageKey = 'Cet alias est déjà pris';
    } else {
        if(!empty($password) && $password != $user->getPassword()) {
            $userModel->updatePassword($_SESSION['playerID'], $password);
        }
        $userModel->updateUser($username, $firstName, $lastName, $_SESSION['playerID']);
        header("Location: /");
    }
}
require 'views/profileForm.php';
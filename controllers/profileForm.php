<?php
if (!isAuthenticated()) {
    echo 'DEV log: You are not logged in. You shouldn\'t be able to see this';
    redirect('/');
}

$pdo = Database::getInstance()->getPDO();
$model = new UserModel($pdo);
$user = $model->selectById($_SESSION['playerID']);
$firstName = $_POST['firstName'] ?? $user->getFirstName();
$lastName = $_POST['lastName'] ?? $user->getLastName();
$username = $_POST['username'] ?? $user->getUsername();
$password = $_POST['password'] ?? '';
$passwordConfirm = $_POST['passwordConfirm'] ?? '';
$messageKey = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle profile updates
    if (isset($_POST['Modifier'])) {
        if (emptyFields($firstName, $lastName, $username)) {
            $messageKey = 'Tous les renseignements doivent être remplis';
        } else if (strlen($password) < 8 && strlen($password) > 0) {
            $messageKey = 'Le mot de passe dois être au moins 8 caractères';
        } else if ($password != $passwordConfirm) {
            $messageKey = 'Les deux mots de passe ne sont pas identiques';
        } else if (!$model->isUsernameAvailable($username) && $username != $user->getUsername()) {
            $messageKey = 'Cet alias est déjà pris';
        } else {
            if (!empty($password) && $password != $user->getPassword()) {
                $model->updatePassword($_SESSION['playerID'], $password);
            }
            $model->updateUser($username, $firstName, $lastName, $_SESSION['playerID']);
            $messageKey = 'Profil mis à jour avec succès';
        }
    }

    // Handle profile picture upload
    if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "public/images/users/";
        $fileName = basename($_FILES["fileToUpload"]["name"]);
        $targetFile = $targetDir . $fileName;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $uploadOk = 1;

        // Validate file type
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check === false) {
            $messageKey = "Le fichier n'est pas une image.";
            $uploadOk = 0;
        }

        // Validate file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            $messageKey = "Désolé, votre fichier est trop volumineux.";
            $uploadOk = 0;
        }

        // Allow only specific file formats
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            $messageKey = "Seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
            $uploadOk = 0;
        }

        // Attempt to upload the file
        if ($uploadOk && move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
            $model->updateUserProfileImage($_SESSION['playerID'], $fileName);
            $messageKey = "L'image de profil a été mise à jour avec succès.";
        } else {
            $messageKey = "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
        }
    }
}

require 'views/profileForm.php';
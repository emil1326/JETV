<?php
//ne peux pas acceder si deja connecter
/*if (isAuthenticated()) {
    redirect('/');
}*/

require 'src/class/Database.php';
require 'models/UserModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {    
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Va créer l'instance ou retourner l'instance
    $db = Database::getInstance(CONFIGURATIONS['database'], DB_PARAMS);
    $pdo = $db->getPDO();
    
    $userModel = new UserModel($pdo);
    $user = $userModel->selectByEmail($email);

    if ($user) {

        if ( password_verify($password, $user->getPassword())) {

            sessionStart();

            $_SESSION['user'] = [
                'id' => $user->getId(),
                'role' => $user->getRole()
            ];

            session_regenerate_id();

            redirect('/');

        }
    }
   
    $messageKey = '<div class="alert alert-danger">Connexion impossible</div>';

}
require 'views/login.php';
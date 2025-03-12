<?php
//redirige a la page d'accueil si deja connecter
/*if (isAuthenticated()) {
    redirect('/');
}*/
require 'src/class/Database.php';
require 'models/UserModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {    

    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $pass = $_POST['pass'] ?? '';
    $pass2 = $_POST['pass2'] ?? '';

    /*
    // Va créer l'instance ou retourner l'instance
    $db = Database::getInstance(CONFIGURATIONS['database'], DB_PARAMS);
    $pdo = $db->getPDO();
    
    $userModel = new UserModel($pdo);*/
    if(!empty(trim($name)) && !empty(trim($email)) && !empty(trim($pass))&& !empty(trim($pass2))){
        if($pass == $pass2 && strlen($pass) >= 8){
            //code creation user ici
            header("Location: /");   
        }else{
            $messageKey = '<div class="alert alert-danger">Les deux mots de passes ne sont pas identiques plus de 8 caractères</div>';
        }
    }else{
        $messageKey = '<div class="alert alert-danger">Tous les renseignements doivent être remplis</div>';
    }
}
require 'views/signup.php';
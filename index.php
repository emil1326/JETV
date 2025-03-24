<?php

require 'src/functions.php';

require 'src/session.php';

require "src/configuration.php";

require "src/class/Database.php";

require "models/UserModel.php";

if(isAuthenticated()){
    $pdo = Database::getInstance()->getPDO();
    $userModel = new UserModel($pdo);
    $user = $userModel -> selectById($_SESSION['playerID']);
    $username = $user -> getUsername();
    $caps = $user -> getCaps();
    $weight = $user -> getMaxWeight();
    $health = $user -> getHealth();
    $dexterity = $user -> getDexterity();
}
routeToController(uriPath());

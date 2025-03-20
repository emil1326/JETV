<?php

require 'src/class/Database.php';
require 'models/ItemModel.php';
require 'models/ShopModel.php';

if (!isAuthenticated()) {
    echo 'DEV log: You are not logged in. You shouldn\'t be able to see this';
    //redirect('/');
}

var_dump($_POST);

$pdo = Database::getInstance()->getPDO();
$model = new ShopModel($pdo);

$items = $model->selectAll();
$shopActif = true; // pour le header, savoir quoi highlight
require 'views/shop.php';

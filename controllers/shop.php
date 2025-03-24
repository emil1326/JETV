<?php

require 'models/ItemModel.php';
require 'models/ShopModel.php';

if (!isAuthenticated()) {
    echo 'DEV log: You are not logged in. You shouldn\'t be able to see this';
    //redirect('/');
}

$pdo = Database::getInstance()->getPDO();
$user = null;

$model = new ShopModel($pdo);

$items = $model->selectAll();
$shopActif = true; // pour le header, savoir quoi highlight
require 'views/shop.php';

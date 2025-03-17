<?php

require 'src/class/Database.php';
require 'models/ItemModel.php';
require 'models/ShopModel.php';

if (!isAuthenticated()) {
    echo 'DEV log: You are not logged in. You shouldn\'t be able to see this';
    //redirect('/');
}

$pdo = Database::getInstance()->getPDO();
$model = new ShopModel($pdo, new ItemModel($pdo));

$items = $model->selectAll();

require 'views/shop.php';

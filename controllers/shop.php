<?php

require 'models/ItemModel.php';
require 'models/ShopModel.php';

$pdo = Database::getInstance()->getPDO();
$user = null;

$model = new ShopModel($pdo);

$items = $model->selectAll();
$shopActif = true; // pour le header, savoir quoi highlight

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    var_dump($_GET);
}

require 'views/shop.php';

<?php

require 'models/ShopModel.php';

$pdo = Database::getInstance()->getPDO();
$user = null;

$model = new ShopModel($pdo);

$items = $model->selectAll();
$shopActif = true; // pour le header, savoir quoi highlight
$filters;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $filters = $_GET;
}


require 'views/shop.php';

<?php

require 'models/ShopModel.php';
require 'src/class/itemFilter.php';


$pdo = Database::getInstance()->getPDO();
$user = null;

$model = new ShopModel($pdo);

$items = $model->selectAll();
$shopActif = true; // pour le header, savoir quoi highlight

$filters = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && count($_GET) > 0) {
    $filters = array_keys($_GET);
    $types = [];
    foreach ($filters as $filter) {
        if (str_starts_with($filter, 'type')) {
            $types[] = substr($filter, 5);
        }
    }

    $filters = $_GET;
    $filters['price_min'] = isset($filters['price_min']) ? $filters['price_min'] : 0;
    $filters['price_max'] = isset($filters['price_max']) ? $filters['price_max'] : null;
    $filters['name'] = isset($filters['name']) ? $filters['name'] : null;


    $filter = new ItemFilter($types, (int)$filters['price_min'], (int)$filters['price_max'], $filters['name']);

    $items = $model->selectFiltered($items, $filter);
}

require 'views/shop.php';

<?php
require 'models/ItemModel.php';
require 'models/ShopModel.php';

$auth = isAuthenticated();

$pdo = Database::getInstance()->getPDO();
$model = new ShopModel($pdo);

$items = $model->selectAll();
$accueilActif = true;

require 'views/index.php';

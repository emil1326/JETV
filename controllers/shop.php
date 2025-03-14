<?php

require 'src/class/Database.php';
require 'models/ItemModel.php';
require 'models/ShopModel.php';

$pdo = Database::getInstance()->getPDO();
$model = new ShopModel($pdo, new ItemModel($pdo));

$items = $model->selectAll();

require 'views/shop.php';


<?php

require 'src/functions.php';

require "src/configuration.php";


require 'src/class/Database.php';
require 'models/ItemModel.php';

$pdo = Database::getInstance()->getPDO();
$itemModel = new ItemModel($pdo);

$comment = $itemModel->selectById(2);

routeToController(uriPath());

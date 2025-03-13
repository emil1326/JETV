<?php

require 'src/functions.php';

require "src/configuration.php";

<<<<<<< HEAD

require 'src/class/Database.php';
require 'models/ItemModel.php';

$pdo = Database::getInstance()->getPDO();
$itemModel = new ItemModel($pdo);

$comment = $itemModel->selectById(2);

=======
>>>>>>> 76645fad964f5e89578996cbcf6566868c464c6c
routeToController(uriPath());

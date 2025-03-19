<?php
if (!isAuthenticated()) {
    echo 'DEV log: You are not logged in. You shouldn\'t be able to see this';
    //redirect('/');
}
require 'src/class/Database.php';
require 'models/ItemModel.php';

$id = $_GET['id'];
$pdo = Database::getInstance()->getPDO();
$itemModel = new ItemModel($pdo);
$item = $itemModel->selectOneFromShop($id);


require 'views/details.php';
<?php
if (!isAuthenticated()) {
    echo 'DEV log: You are not logged in. You shouldn\'t be able to see this';
    //redirect('/');
}
require 'src/class/Database.php';
require 'models/ItemModel.php';

<<<<<<< HEAD
$id = $_GET['id'];
$pdo = Database::getInstance()->getPDO();
$itemModel = new ItemModel($pdo);
$item = $itemModel->selectOneFromShop($id);
=======
# input => playerID, itemID

# output => one item or redirect to menu
>>>>>>> 7307048aa8a57c2adbc9f4439abd8db4ca33a875

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $parts = parse_url($url);
    parse_str($parts['query'], $query);

<<<<<<< HEAD
require 'views/details.php';
=======
    $pdo = Database::getInstance()->getPDO();
    $model = new ShopModel($pdo);

    $item = null;

    if (isset($query['playerID'])) // pour l'inventaire
        $item = $model->selectOneByPlayerIdFromInventory($query['itemID'], $query['playerID']);
    if (isset($query['itemID'])) // pour shop et cart
        $item = $model->selectOneFromShop($query['itemID']);

    if ($item == null)
        if (isset($query['playerID']))
            redirect('/backpack'); // guess qui faut aller au backpack si erreure mais avc un idplayer => peu etre si le le itemID existe pas pour se joueur
        else
            redirect('/'); // redirect to homepage si ni playerID ni itemID, peu pas show l'item

    // dans le cart et shop on a les meme pages
} else {
    redirect("/");  // todo change vers une page custom ??
}

require 'views/cart.php';
>>>>>>> 7307048aa8a57c2adbc9f4439abd8db4ca33a875

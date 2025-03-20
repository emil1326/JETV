<?php
if (!isAuthenticated()) {
    echo 'DEV log: You are not logged in. You shouldn\'t be able to see this';
    //redirect('/');
}
require 'src/class/Database.php';
require 'models/ItemModel.php';

# input => playerID, itemID

# output => one item or redirect to menu

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $parts = parse_url($_SERVER['REQUEST_URI']);
    parse_str($parts['query'], $query);

    $pdo = Database::getInstance()->getPDO();


    $item = null;

    if (isset($query['player_id'])) { // pour l'inventaire
        $itemModel = new ItemModel(pdo: $pdo);
        $item = $model->selectOneByPlayerIdFromInventory($query['itemID'], $query['playerID']);
    } else if (isset($query['item_id'])) { // pour shop et cart
        $shopModel = new ShopModel(pdo: $pdo); // todo change to shopmodel
        $item = $shopModel->selectOne($query['itemID']); // todo change vers
    }

    if ($item == null) // pas else pcq les func peuvent return null
        if (isset($query['playerID']))
            redirect('/backpack'); // guess qui faut aller au backpack si erreure mais avc un idplayer => peu etre si le le itemID existe pas pour se joueur
        else
            redirect('/'); // redirect to homepage si ni playerID ni itemID, peu pas show l'item

    // dans le cart et shop on a les meme pages
} else {
    redirect("/");  // todo change vers une page custom ??
}

require 'views/details.php';

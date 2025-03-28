<?php
if (!isAuthenticated()) {
    echo 'DEV log: You are not logged in. You shouldn\'t be able to see this';
    redirect('/shop');
}
require 'models/ShopModel.php';

# input => playerID, itemID

# output => one item or redirect to menu

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $parts = parse_url($_SERVER['REQUEST_URI']);
    parse_str($parts['query'], $query);

    $pdo = Database::getInstance()->getPDO();


    $item = null;

    if (isset($query['playerID'])) { // pour l'inventaire
        $itemModel = new ItemModel(pdo: $pdo);
        $item = $itemModel->selectOneByPlayerIdFromInventory($query['itemID'], $query['playerID']);
    } else if (isset($query['itemID'])) { // pour shop et cart
        $shopModel = new ShopModel(pdo: $pdo); // todo change to shopmodel
        $item = $shopModel->selectOne($query['itemID']); // todo change vers

        /*  FIXME: The type check and attributes assignement should be outside of this `if`, but 
            the methods aren't recognized */

        if (get_class($item) == 'Weapon') {
            $attributes = [
                'efficiency' => $item->getEfficiency(),
                'genre' => $item->getGenre(),
                'caliber' => $item->getCaliber()
            ];
        } else if (get_class($item) == 'Armor') {
            $attributes = [
                'material' => $item->getMaterial(),
                'size' => $item->getSize()
            ];
        } else if (get_class($item) == 'Meds') {
            $attributes = [
                'healthGain' => $item->getHealthGain(),
                'effect' => $item->getEffect(),
                'duration' => $item->getDuration(),
                'unwantedEffect' => $item->getUnwantedEffect()
            ];
        } else if (get_class($item) == 'Food') {
            $attributes = [
                'healthGain' => $item->getHealthGain(),
                'calories' => $item->getCalories(),
                'getMainNutriment' => $item->getMainNutriment(),
                'mainMineral' => $item->getMainMineral()
            ];
        } else if (get_class($item) == 'Ammo') {
            $attributes = [
                'caliber' => $item->getCaliber()
            ];
        }
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

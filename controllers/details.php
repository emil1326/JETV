<?php
if (!isAuthenticated()) {
    echo 'DEV log: You are not logged in. You shouldn\'t be able to see this';
    redirect('/shop');
}
require 'models/ShopModel.php';
require 'models/CartModel.php';

$pdo = Database::getInstance()->getPDO();

# input => playerID, itemID, fromCart = false

# output => one item or redirect to menu

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $parts = parse_url($_SERVER['REQUEST_URI']);
    parse_str($parts['query'], $query);


    $item = null;

    if (isset($query['playerID'])) { // pour l'inventaire
        if (isset($query['use'])) {
            // need use
            $inventoryModel = new InventoryModel($pdo);
            $did = $inventoryModel->useItem($query['itemID'], $_SESSION['playerID']);
        }
        $inventoryModel = new InventoryModel(pdo: $pdo);
        $result  = $inventoryModel->selectOne($query['itemID'], $query['playerID']);
        if ($result !== null) {
            [$item, $qt] = [$result['item'], $result['quantity']];
        }
    } else if (isset($query['itemID'])) { // pour shop et cart
        $shopModel = new ShopModel(pdo: $pdo); // todo change to shopmodel
        $result = $shopModel->selectOne($query['itemID']);
        if ($result !== null) {
            [$item, $qt] = [$result['item'], $result['quantity']];
        }
    }
    else
    {
        echo 'missing args';
        // redirect('/');
    }

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


    if ($item == null) // pas else pcq les func peuvent return null
        if (isset($query['playerID']))
            redirect('/backpack'); // guess qui faut aller au backpack si erreure mais avc un idplayer => peu etre si le le itemID existe pas pour se joueur
        else
            redirect('/'); // redirect to homepage si ni playerID ni itemID, peu pas show l'item -> apres avoir fais genre un sell buy use

    // dans le cart et shop on a les meme pages
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $itemID = $_POST['itemID'] ?? null;
    $quantity = $_POST['quantity'] ?? 0;

    if ($itemID != null && $quantity > 0 /* && isset($_POST['buy'])*/ ) {
        // add to cart
        $cartModel = new CartModel(Database::getInstance()->getPDO());
        $cartModel->addItemToCart($_SESSION['playerID'], $itemID, $quantity);
        redirect('/shop');
    }
    if (isset($_POST['sell']) && $_POST['sell'] == 1) {
        // vendre item
        $inventoryModel = new InventoryModel($pdo);
        $inventoryModel->sellItem($itemID, $_SESSION['playerID'], $quantity); // broken pcq lautre avant prend toujour, faut tou refactor pcq la c trop split la maniere que c fait
    }
} else {
    redirect("/");  // todo change vers une page custom ??
}

require 'views/details.php';

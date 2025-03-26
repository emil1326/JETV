<?php

if (!isAuthenticated()) {
    echo 'DEV log: You are not logged in. You shouldn\'t be able to see this';
    //redirect('/');
}

$backActif = true; // pour le header, savoir quoi highlight

require 'models/InventoryModel.php';

# input => vieux params des forms => useItem + itemID

# output => 

$items = null;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $parts = parse_url($_SERVER['REQUEST_URI']);

    $pdo = Database::getInstance()->getPDO();
    $modelInvantaire = new InventoryModel($pdo);

    // si true on a un arg
    if (isset($parts['query'])) {
        parse_str($parts['query'], $query);

        // si a acheter
        if (isset($query['useItem'])) {
            //do useitem
            if ($modelInvantaire->useItem($query['itemID'], $_SESSION['playerID']))
                echo 'did';
            else
                echo 'err';
        }
    }
    // juste show
    $item = $modelInvantaire->selectAllByPlayerIdFromCart($_SESSION['playerID']);
} else {
    # err
    redirect('/');
}


require 'views/backpack.php';

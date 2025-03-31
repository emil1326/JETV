<?php

if (!isAuthenticated()) {
    echo 'DEV log: You are not logged in. You shouldn\'t be able to see this';
    //redirect('/');
}

$backActif = true; // pour le header, savoir quoi highlight

require 'src/class/ItemFilter.php';

$pdo = Database::getInstance()->getPDO();
$model = new InventoryModel($pdo);

$items = $model->selectAll($_SESSION['playerID']);
$filters = [];

# input => vieux params des forms => useItem + itemID

# output => 


//  TODO: Revise useItem (code below) to merge it with filters code

/*

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
    $items = $modelInvantaire->selectAll($_SESSION['playerID']);
} else {
    # err
    redirect('/');
}
*/


if ($_SERVER['REQUEST_METHOD'] === 'GET' && count($_GET) > 0) {
    $filters = array_keys($_GET);
    $types = [];
    foreach ($filters as $filter) {
        if (str_starts_with($filter, 'type')) {
            $types[] = substr($filter, 5);
        }
    }

    $filters = $_GET;
    $filters['price_min'] = isset($filters['price_min']) ? (int) $filters['price_min'] : 0;
    $filters['price_max'] = isset($filters['price_max']) ? (int) $filters['price_max'] : 0;
    $filters['name'] = isset($filters['name']) ? $filters['name'] : null;

    $filter = new ItemFilter($types, $filters['price_min'], $filters['price_max'], $filters['name']);

    $items = $model->selectFiltered($items, $filter);
} else {
    $filters = [
        'types' => null,
        'price_min' => null,
        'price_max' => null,
        'name' => null,
    ];
}

require 'views/backpack.php';

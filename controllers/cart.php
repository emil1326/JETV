<?php
if (!isAuthenticated()) {
    echo 'DEV log: You are not logged in. You shouldn\'t be able to see this';
    // redirect('/');
}

require 'models/CartModel.php';

# input => vieux params des forms => update les qt. , pay => call BD
# itemID = int,  addItem removeItem clearItem buy peuPasAcheter tropHeavy

# output => pays => bool to self

$cartActif = true; // pour le header, savoir quoi highlight

$items = null;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $parts = parse_url($_SERVER['REQUEST_URI']);

    $pdo = Database::getInstance()->getPDO();
    $modelCart = new CartModel($pdo);

    $items = $modelCart->selectAll($_SESSION['playerID']);
    $totalWeight = 0;
    $totalPrice = 0;
    $totalCount = 0;

    // si true on a un arg
    if (isset($parts['query'])) {
        parse_str($parts['query'], $query);

        // si a acheter
        if (isset($query['buy'])) {
            //do buy bd
            $res = $modelCart->buyCart($_SESSION["playerID"]);
            if ($res)
                redirect('/backpack');
            else {
                redirect('/cart?error=peuPasAcheter');
            }
        } elseif (isset($query['addItem'])) {
            // 
            $res =  $modelCart->addItemToCart($_SESSION["playerID"], $query['itemID'],  1);
            if ($res)
                redirect('/cart');
            else {
                redirect('/cart?error=peuPasAdd');
            }
        } elseif (isset($query['removeItem'])) {
            // 
            $res =  $modelCart->removeItemFromCart($_SESSION["playerID"], $query['itemID'], 1);
            if ($res)
                redirect('/cart');
            else {
                redirect('/cart?error=peuPasRemove');
            }
        } elseif (isset($query['clearItems'])) {
            //
            $res =     $modelCart->clearCart($_SESSION["playerID"]);
            if ($res)
                redirect('/shop');
            else {
                redirect('/cart?error=peuPasClear');
            }
        }
    }

    // if need other error codes
    if (isset($query['error'])) {
        if ($query['error'] == 'peuPasAcheter')
            $peuPasAcheter = true;
        if ($query['error'] == 'tropHeavy')
            $tropHeavy = true;
        if ($query['error'] == 'peuPasAdd')
            $peuPasAdd = true;
        if ($query['error'] == 'peuPasRemove')
            $peuPasRemove = true;
        if ($query['error'] == 'peuPasClear')
            $peuPasClear = true;
    }

    if (isset($items))
        foreach ($items as $itemData) {
            $item = $itemData['item'];
            $quantity = $itemData['quantity'];

            $totalWeight += $item->getItemWeight() * $quantity;
            $totalPrice += $item->getBuyPrice() * $quantity;
            $totalCount += $quantity;
        }
} else {
    # err
    redirect('/');
}

// var_dump($items);
// echo $_SESSION['playerID'];

require 'views/cart.php';

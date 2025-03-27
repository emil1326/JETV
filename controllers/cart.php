<?php
if (!isAuthenticated()) {
    echo 'DEV log: You are not logged in. You shouldn\'t be able to see this';
    // redirect('/');
}

require 'models/CartModel.php';

# input => vieux params des forms => update les qt. , pay => call BD
# itemID = int,  addItem removeItem clearItem buy

# output => pays => bool to self

$cartActif = true; // pour le header, savoir quoi highlight

$items = null;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $parts = parse_url($_SERVER['REQUEST_URI']);

    $pdo = Database::getInstance()->getPDO();
    $modelCart = new CartModel($pdo);

    // si true on a un arg
    if (isset($parts['query'])) {
        parse_str($parts['query'], $query);

        // si a acheter
        if (isset($query['buy'])) {
            //do buy bd
            $res = $modelCart->buyCart($_SESSION["playerID"]);
            if ($res)
                redirect('/inventaire');
            else {

                echo 'Error peu pas acheter??';
                // redirect('/cart') // temp, remettre apres et enlver le err message
            }
        } elseif (isset($query['addItem'])) {
            // 
            $modelCart->addItemToCart($_SESSION["playerID"], $query['itemID']);
        } elseif (isset($query['removeItem'])) {
            // 
            $modelCart->addItemToCart($_SESSION["playerID"], $query['itemID']);
        } elseif (isset($query['clearItems'])) {
            //
            $modelCart->clearCart($_SESSION["playerID"]);
        }
    }
    // juste show
    $items = $modelCart->selectAllByPlayerIdFromCart($_SESSION['playerID']);
} else {
    # err
    redirect('/');
}

require 'views/cart.php';

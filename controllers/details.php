<?php
if (isAuthenticated()) {
    $auth = true;
} else {
    $auth = false;
}

require 'models/ShopModel.php';
require 'models/CommentModel.php';


$pdo = Database::getInstance()->getPDO();
$commentModel = new CommentModel($pdo);
# input => playerID, itemID, fromCart = false
# use buy sell quantity isPlayer

# output => one item or redirect to menu or use item or redirect ot backpack



if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $parts = parse_url($_SERVER['REQUEST_URI']);
    parse_str($parts['query'], $query);

    $quantity = $query['quantity'] ?? 0;
    $itemID = $query['itemID'] ?? -1; // => should error


    $item = null;

    if (isset($query['isPlayer']) && isset($query['itemID'])) {
        // pour l'inventaire et cart
        $inventoryModel = new InventoryModel($pdo);

        $inShop = false;

        if (isset($query['use'])) {
            // need use
            $did = $inventoryModel->useItem($itemID, $_SESSION['playerID']);
            if ($did)
                redirect('/details?itemID=' . $itemID . '&isPlayer');
            else
                redirect('/details?itemID=' . $itemID . '&isPlayer&error=peuPasUtuliser');
        }

        if (isset($query['sell'])) {
            // need sell
            $inventoryModel = new InventoryModel($pdo);
            $did = $inventoryModel->sellItem($itemID, $_SESSION['playerID'], $quantity);
            if ($did)
                redirect('/backpack');
            else
                redirect('/details?itemID=' . $itemID . '&isPlayer&error=peuPasVendre');
        }

        $result = $inventoryModel->selectOne($itemID, $_SESSION['playerID']);
        if ($result !== null) {
            [$item, $qt] = [$result['item'], $result['quantity']];
        } else {
            redirect('/backpack');
        }
    } else if (isset($query['itemID'])) {
        // pour shop 
        $shopModel = new ShopModel(pdo: $pdo); // todo change to shopmodel

        $inShop = true;

        if (isset($query['buy'])) {
            // need buy
            $cartModel = new CartModel(Database::getInstance()->getPDO());
            $did = $cartModel->addItemToCart($_SESSION['playerID'], $itemID, $quantity);
            if ($did)
                redirect('/shop');
            else
                redirect('/details?itemID=' . $itemID . '&error=peuPasAcheter');
        }

        $result = $shopModel->selectOne($itemID);
        if ($result !== null) {
            [$item, $qt] = [$result['item'], $result['quantity']];
        } else {
            redirect('/shop');
        }
    } else {
        redirect('/');
    }

    $qt ?? -1;

    if (isset($query['error']))
        if ($query['error'] == 'peuPasUtuliser')
            $peuPasUse = true;
        elseif ($query['error'] == 'peuPasVendre')
            $peuPasVendre = true;
        elseif ($query['error'] == 'peuPasAcheter')
            $peuPasAcheter = true;

    $attributes = $item->getAttributes();

    if ($item == null)
        if (isset($query['isPlayer']))
            redirect('/backpack'); // guess qui faut aller au backpack si erreure mais avc un idplayer => peu etre si le le itemID existe pas pour se joueur
        else
            redirect('/'); // redirect to homepage si ni playerID ni itemID, peu pas show l'item -> apres avoir fais genre un sell buy use

} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $commentText = trim($_POST['comment']);

    if (!empty($commentText) && isset($_POST['playerID'], $_POST['itemID'], $_POST['stars'])) {
        $commentModel->addComment($_POST['itemID'], $_POST['playerID'], $commentText, $_POST['stars']);
    }
    redirect('/details?itemID=' . $_POST['itemID']);
} else {
    redirect("/");  // todo change vers une page custom ??
}





$comments = $commentModel->selectAllByItemId($itemID);

$userModel = new UserModel($pdo);

$commentsData = [];
if (isset($comments))
    foreach ($comments as $comment) {
        $user = $userModel->selectById($comment->getUserId());
        $commentsData[] = [
            "username" => $user->getUsername(),
            "userProfileImage" => $user->getProfileImage(),
            "comment" => $comment->getComment(),
            "starCount" => $comment->getStarCount()
        ];
    }

require 'views/details.php';

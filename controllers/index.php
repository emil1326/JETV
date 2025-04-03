<?php
require 'models/ShopModel.php';

$auth = isAuthenticated();

$pdo = Database::getInstance()->getPDO();
$model = new ShopModel($pdo);

$items = $model->selectAll();
$accueilActif = true;

if ($_SESSION['lastCaps'] > time() + 86400)
    $canGetCaps = true;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $parts = parse_url($_SERVER['REQUEST_URI']);
    parse_str($parts['query'], $query);

    $getCaps = $query['getCaps'] ?? 0;

    if ($_SESSION['lastCaps'] > time() + 86400) {
        $userModel = new UserModel($pdo);
        $userModel->addCaps(200, $_SESSION['playerID']);
    }
}

require 'views/index.php';

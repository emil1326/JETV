<?php
require 'models/ShopModel.php';

$auth = isAuthenticated();

$pdo = Database::getInstance()->getPDO();
$model = new ShopModel($pdo);

$items = $model->selectAll();
$accueilActif = true;

if (!isset($_SESSION['lastCapsTime']))
    $_SESSION['lastCapsTime'] = 0; // premier log so set to 0

if ($_SESSION['lastCapsTime'] > time() + 86400) // 84600 => one day
    $canGetCaps = true;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $parts = parse_url($_SERVER['REQUEST_URI']);
    if (isset($parts['query'])) {
        parse_str($parts['query'], $query);

        $getCaps = $query['getCaps'] ?? 0;

        if ($_SESSION['lastCapsTime'] > time() + 86400) {
            $userModel = new UserModel($pdo);
            $res =  $userModel->addCaps(200, $_SESSION['playerID']);
            if ($res) {
                $_SESSION['lastCaps'] = time();
                $gotCaps = true;
            }
        }
    }
}

require 'views/index.php';

<?php
require 'models/ShopModel.php';
// fix me
$auth = isAuthenticated();

// in => getCaps

// out => canGetCaps gotCaps couldntGetCaps

$pdo = Database::getInstance()->getPDO();
$model = new ShopModel($pdo);

$items = $model->selectAll();
$accueilActif = true;

// Fetch lastCapsTime from the database
$lastCapsTime = 0;
if ($auth) {
    $userModel = new UserModel($pdo);
    $lastCapsTime = $userModel->getLastCapsTime($_SESSION['playerID']);

    if ($lastCapsTime == 0) {
        $lastCapsTime = time() + 86401; // premier log so set to day + 1 (so can get quand c la premiere fois tu te log)
        $userModel->updateLastCapsTime($_SESSION['playerID'], $lastCapsTime);
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET)) {
    if (($lastCapsTime + 86400) <= time() && $auth) {
        $canGetCaps = true;
        // choices
        if ($_GET['getCaps']) {
            $userModel->updateLastCapsTime($_SESSION['playerID'], time());
            $res =  $userModel->addCaps(200, $_SESSION['playerID']);
            if ($res) {
                $_SESSION['lastCaps'] = time();
                $gotCaps = true;
                $doNotRefresh = true; // ne pas refresh apres sa
            } else {
                $couldntGetCaps = true;
            }
            $canGetCaps = false;
        }
    }
}

$canGetCaps = true;

require 'views/index.php';

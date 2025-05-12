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
$userModel = new UserModel($pdo);
$lastCapsTime = $userModel->getLastCapsTime($_SESSION['playerID']);

if (!$lastCapsTime) {
    $lastCapsTime = time() + 86401; // premier log so set to day + 1 (so can get quand c la premiere fois tu te log)
    $userModel->updateLastCapsTime($_SESSION['playerID'], $lastCapsTime);
}
echo 'wa';
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET)) {
    echo 'wa';
    if (($lastCapsTime + 86400) <= time() && $auth) {
        echo 'wa';
        $canGetCaps = true;
        // choices
        if ($_GET['getCaps']) {
            echo 'wa';
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

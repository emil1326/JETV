<?php

function sessionStart(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function sessionDestroy(): void
{
    session_destroy();

    $name = session_name();
    $expire = new DateTime("-1 year");
    $expireTimestamp =  $expire->getTimestamp();
    $params = session_get_cookie_params();

    setcookie(
        $name,
        "",
        $expireTimestamp,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

function isAuthenticated(): bool
{
    sessionStart();
    $res = isset($_SESSION) && isset($_SESSION['playerID']) && $_SESSION['playerID'] != -1;

    if ($res != false) {
        // logout on account destroyed
        $um = new UserModel(pdo: Database::getInstance()->getPDO());
        if ($um->selectById($_SESSION['playerID']) == null)
            redirect('/logout');
    }

    return $res;
}

<?php

function sessionStart(): void
{
    if (session_status() === PHP_SESSION_NONE) {

        session_start();
    }
}

function sessionDestroy(): void
{
    $_SESSION = [];
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

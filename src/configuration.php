<?php

const ROUTES = [

    '/' => 'index.php',
    '/cart' => 'cart.php',
    '/backpack' => 'backpack.php',
    '/shop' => 'shop.php',
    '/login' => 'login.php',
    '/signup' => 'signup.php',
    '/enigma' => 'enigma.php',
    '/details' => 'details.php',
    '/detailstemp' => 'detailstemp.php',
    '/logout' => 'logout.php'

];

const DB_PARAMS = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_CASE => PDO::CASE_NATURAL,
    PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING,
];

define('CONFIGURATIONS', parse_ini_file("configurations.ini", true));

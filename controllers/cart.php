<?php
if (!isAuthenticated()) {
    echo 'DEV log: You are not logged in. You shouldn\'t be able to see this';
    //redirect('/');
}
$cartActif = true;
require 'views/cart.php';
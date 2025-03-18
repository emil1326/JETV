<?php
if (!isAuthenticated()) {
    echo 'DEV log: You are not logged in. You shouldn\'t be able to see this';
    //redirect('/');
}
require 'src/class/Database.php';
require 'models/ItemModel.php';

$item = [

];


require 'views/cart.php';
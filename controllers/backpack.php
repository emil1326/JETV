<?php
require 'src/class/Database.php';
if (!isAuthenticated()) {
    echo 'DEV log: You are not logged in. You shouldn\'t be able to see this';
    //redirect('/');
}
$backActif = true; // pour le header, savoir quoi highlight
require 'views/backpack.php';
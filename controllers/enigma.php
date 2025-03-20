<?php
if (!isAuthenticated()) {
    echo 'DEV log: You are not logged in. You shouldn\'t be able to see this';
    //redirect('/');
}
$enigmaActif = true; // pour le header, savoir quoi highlight
require 'src/class/Database.php';
require 'views/enigma.php';
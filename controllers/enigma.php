<?php

$enigmaActif = true; // pour le header, savoir quoi highlight

if (!isAuthenticated()) {
    echo 'DEV log: You are not logged in. You shouldn\'t be able to see this';
    //redirect('/');
}

require 'views/enigma.php';

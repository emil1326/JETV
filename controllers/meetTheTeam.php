<?php

$selectedMember = null;

if (isset($_GET['Member']))
    if (str_contains($_GET['Member'], "Jona"))
        $selectedMember = 0;
    elseif (str_contains($_GET['Member'], "Emil"))
        $selectedMember = 1;
    elseif (str_contains($_GET['Member'], "Thom"))
        $selectedMember = 2;
    elseif (str_contains($_GET['Member'], "Victo"))
        $selectedMember = 3;


$members = [
    ['letter' => 'J', 'name' => 'Jonathan'],
    ['letter' => 'E', 'name' => 'Emilien'],
    ['letter' => 'T', 'name' => 'Thomas'],
    ['letter' => 'V', 'name' => 'Victor'],
];

require 'views/meetTheTeam.php';

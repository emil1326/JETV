<?php
$site = '';
require 'partials/head.php';
require 'partials/header.php';
?>

<link rel="stylesheet" href="public/css/enigma.css">

<div class="container marketing">
    <div id="enigmaChoixLayout" class="px-4 py-5 my-5">
        <h1 id="enigmaStrH1" class="display-5 fw-bold text-body-emphasis text-center">
            Choissisez votre
            difficulté </h1>

        <div class="masonry">
            <div class="item item1 buttonCursorPointer" onclick="window.location.href='/shop'">Facile</div>
            <div class="item item2 buttonCursorPointer" onclick="window.location.href='/shop'">Moyen</div>
            <div class="item item3 buttonCursorPointer" onclick="window.location.href='/shop'">Difficile</div>

        </div>
        <div id="enigmaStrRetour" class="col-lg-6 mx-auto mb-3 text-center">
            <a href="/" type="button" class="btn btn-secondary">Retours a l'Accueil</a>
        </div>
    </div>
</div>

<?php
require 'partials/footer.php';
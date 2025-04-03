<?php
$site = '';
require 'partials/head.php';
require 'partials/header.php';
?>

<style>
    .masonry {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        grid-auto-rows: 10px;
        gap: 20px;
    }

    .item {
        background-color: #ffffff;
        padding: 20px;
        box-sizing: border-box;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        transition: transform 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2em;
        color: #fff;
    }

    .item:hover {
        transform: translateY(-10px);
    }

    .item1 {
        grid-row: span 10;
        background-color: #88b04b;
    }

    .item2 {
        grid-row: span 10;
        background-color: #6b5b95;
    }

    .item3 {
        grid-row: span 10;

        background-color: #ff6f61;
    }
</style>

<div class="container marketing">
    <div class="px-4 py-5 my-5 ">
        <h1 class="display-5 fw-bold text-body-emphasis text-center" style="margin-bottom:30px; font-size:20px;">
            Choissisez votre
            difficulté </h1>

        <div class="masonry">
            <div class="item item1">Facile</div>
            <div class="item item2">Moyen</div>
            <div class="item item3">Difficile</div>

        </div>

        <div class="col-lg-6 mx-auto mb-3 text-center">
            <a href="/" type="button" class="btn btn-secondary">Retours a l'Accueil</a>
        </div>
    </div>
</div>

<?php
require 'partials/footer.php';
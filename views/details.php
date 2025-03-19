<?php
require 'views/partials/head.php';
require 'views/partials/header.php';
?>

<!-- in: item
 
    

-->
<style>
    .card-group .card {
        max-width: 325px !important;
        min-width: 270px !important;
        min-height: 400px !important;
        border: 1px;
        transition: all 0.5s ease;
    }

    .card-group .card:hover {
        transform: scale(1.05);
        box-shadow: 0 0 3px white;
    }

    @media (max-width: 576px) {
        .card-group {
            display: flex;
            flex-flow: row wrap;
        }
    }
</style>
<?php if (isset($item)): ?>
<div class="card"
style="background-color:#1E1E1E !important; padding:10px; cursor:pointer;border:1px white solid;border-color: #6c757d; border-radius:8px; margin:20px; margin-top:0px; margin-bottom:0px;">
    <div class="numberCircle" style="margin-right:0px;"></div>
        <img class="card-img-top"
        src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ-YtnuV2n_8xuMZbIQ8voSyC4hjGBN6DLC8w&s"
        alt="Card image cap">
        <div class="card-body" style="margin-bottom:20px;">

            <h5 class="card-title">
                <?= $item->getName() ?>
            </h5>
            <p class="card-text">$<?= $item->getBuyPrice() ?></p>
            <p class="card-text"><small class="text-muted">Poids : <?= $item->getItemWeight() ?>
            kg<br></small></p>

    </div>
</div>
<?php endif ?>


<?php
require 'views/partials/footer.php';
?>
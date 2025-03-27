<?php
require 'views/partials/head.php';
require 'views/partials/header.php';
?>

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

<div class="card text-center" style="background-color: #303030;">

    <div class="card-body" style="padding-top:200px; padding-bottom: 200px;">
        <h1 class="card-title" style="font-size:60px;font-weight: bold;">JETV™</h1>
        <p class="card-text" style="font-size:30px;">Le magasin</p>
        <div style="display:flex; flex-direction:row; justify-content:center;">
            <a href="/shop" class="btn btn-outline-secondary buttonsw" 
            style="color:white; margin-right:10px;  border-radius: 8px;padding-top:4px; background-color: #303030;">Shop</a>
            <?php if (isAuthenticated()) : ?>
                <a href="/enigma" class="btn  btn-outline-secondary buttonsw" 
                style="color:black; background-color:white; border-radius: 8px;padding-top:4px;">Enigma</a></button>
            <?php endif; ?>
        </div>
    </div>

</div>
<div style="display:flex; flex-direction:column; height:auto; width:100%;padding:64px;">
    <div style="display:flex; flex-direction: column;">
        <p style="font-size:30px;font-weight:bold;"><a href="/shop" style="text-decoration: none; color:white;">Shop</a>
        </p>
        <p style="font-size:20px; margin-top:-10px;margin-bottom:30px;"><a href="/shop"
                style="text-decoration: none; color:white;">View more</a></p>
    </div>
    <div style="display:flex; justify-content:center;">
        <div class="card-group" style="display:flex; justify-content: center; row-gap: 3ch;">
            <?php $count = 0 ?>
            <?php if (isset($items)): ?>
                <?php foreach ($items as $index => $item): ?>
                    <?php if ($count < 3): ?>
                        <div class="card"
                            style="background-color:#1E1E1E !important; padding:10px; cursor:pointer;border:1px white solid;border-color: #6c757d; border-radius:8px; margin:20px; margin-top:0px; margin-bottom:0px;"
                            onclick="window.location.href='/shop';">
                            <div class="numberCircle"><?= $item['quantity'] ?></div>
                            <img class="card-img-top"
                                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ-YtnuV2n_8xuMZbIQ8voSyC4hjGBN6DLC8w&s"
                                alt="Card image cap">
                            <div class="card-body" style="margin-bottom:20px;">

                                <h5 class="card-title">
                                    <?= $item['item']->getName() ?>
                                </h5>
                                <p class="card-text">$<?= $item['item']->getBuyPrice() ?></p>
                                <p class="card-text"><small class="text-muted">Poids : <?= $item['item']->getItemWeight() ?>
                                        kg<br></small></p>
                            </div>

                        </div>
                    <?php endif ?>
                    <?php $count++ ?>
                <?php endforeach; ?>
            <?php endif ?>
        </div>
    </div>
</div>

<?php
require 'views/partials/footer.php';
?>

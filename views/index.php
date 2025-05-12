<?php
require 'views/partials/head.php';
require 'views/partials/header.php';

if (!isset($canGetCaps))
    $canGetCaps = false;

if (!isset($gotCaps))
    $gotCaps = false;

if (!isset($couldntGetCaps))
    $couldntGetCaps = false;

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

    #daily {
        width: 100%;
        background-color: transparent;
    }

    #daily2 {
        width: 100%;
        background-color: transparent;
    }
</style>

<!-- comment -->

<?php if ($canGetCaps): ?>

    <!-- floating popup getCaps -->

    <div id="daily" class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true"
        data-bs-autohide="false" style="text-align:center; font-size:18px; background-color: #bdbfbe">
        <div class=" d-flex" style="justify-content: center;">
            <div class="toast-body" style="color:black;">
                Hello! Réclamez vos 200 caps quotidien !


                <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="toast" aria-label="Close"
                    style="background-color:black; border:none; margin-left:10px; font-size:18px;">Claim</button>


            </div>
        </div>
    </div>
<?php elseif ($gotCaps): ?>

    <!-- floating popup gotCaps -->

    <div id="daily2" class="toast2 align-items-center" role="alert" aria-live="assertive" aria-atomic="true"
        data-bs-autohide="false" style="text-align:center; font-size:18px; background-color: #bdbfbe">
        <div class=" d-flex" style="justify-content: center;">
            <div class="toast-body" style="color:black;">
                Vous avez gagné 200 caps!


                <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="toast2" aria-label="Close"
                    style="background-color:black; border:none; margin-left:10px; font-size:18px;">Close</button>


            </div>
        </div>
    </div>
<?php elseif ($couldntGetCaps): ?>

    <!-- floating popup error got caps -->

    <div id="daily3" class="toast2 align-items-center" role="alert" aria-live="assertive" aria-atomic="true"
        data-bs-autohide="false" style="text-align:center; font-size:18px; background-color: #bdbfbe">
        <div class=" d-flex" style="justify-content: center;">
            <div class="toast-body" style="color:black;">

                Erreur: 200 caps non reçus

                <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="toast2" aria-label="Close"
                    style="background-color:black; border:none; margin-left:10px; font-size:18px;">Close</button>


            </div>
        </div>
    </div>
<?php endif ?>



<div class="card text-center" style="background-color: #303030;">

    <div class="card-body" style="padding-top:200px; padding-bottom: 200px;">

        <h1 class="card-title" style="font-size:60px;font-weight: bold;">JETV™</h1>
        <p class="card-text" style="font-size:30px;">Le magasin</p>
        <div style="display:flex; flex-direction:row; justify-content:center;">
            <a href="/shop" class="btn btn-outline-secondary buttonsw"
                style="color:white; margin-right:10px;  border-radius: 8px;padding-top:4px; background-color: #303030;">Shop</a>
            <?php if (isAuthenticated()): ?>
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
                            style="background-color:#1E1E1E !important; padding:20 10px; cursor:pointer;border:1px white solid;border-color: #6c757d; border-radius:8px; margin:20px; margin-top:0px; margin-bottom:0px;"
                            onclick="window.location.href= '/details?itemID=<?= $item['item']->getId() ?>'">
                            <div class="numberCircle"><?= $item['quantity'] ?></div>
                            <img class="card-img-top" src="public/images/products/<?= $item['item']->getImageLink() ?>"
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
<script>
    const toast = document.getElementById('daily');
    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast);
    toastBootstrap.show();

    const toast2 = document.getElementById('daily2');
    const toastBootstrap2 = bootstrap.Toast.getOrCreateInstance(toast2);
    toastBootstrap2.show();
</script>
<?php
require 'views/partials/footer.php';
?>

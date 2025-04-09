<?php
require 'views/partials/head.php';
require 'views/partials/header.php';
?>
<style>
    .star-rating input {
        display: none;
    }

    .colorStar {

        color: white;

    }

    .cardCar {
        background-color: #303030;
        color: white;
        border: none;
    }

    icon-shape {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        vertical-align: middle;
    }

    .icon-sm {
        width: 2rem;
        height: 2rem;

    }
</style>

<div>
    <div style="display:flex; justify-content: center; flex-direction:column; align-items:center; margin-bottom:30px;">
        <p style="margin:0px; font-size:23px; font-weight: bold;"> Votre panier </p>
        <p style="font-size:18px;"> <?= isset($items) ? $totalCount : "0" ?> items</p>
        <?php if (isset($peuPasAcheter)): ?>
            <p>Peu pas acheter</p>
        <?php endif ?>
        <?php if (isset($peuPasAdd)): ?>
            <p>Peu pas ajouter plus d'items</p>
        <?php endif ?>
        <?php if (isset($peuPasRemove)): ?>
            <p>Peu pas remove cet item</p>
        <?php endif ?>
        <?php if (isset($peuPasClear)): ?>
            <p>Peu pas clear le cart</p>
        <?php endif ?>
        <!-- should do if free sprint 2 -->
        <?php if (isset($tropHeavy)): ?>
            <p>Attention vous etes peut-etre trop heavy</p>
        <?php endif ?>
    </div>
    <div style="display:flex; justify-content: center; flex-direction: row;">
        <div
            style="display:flex; justify-content: center; align-items: center;height:auto; margin-right:<?= isset($items) ? '70px' : '0px' ?>;">

            <!-- cards -->

            <div style="display:flex; justify-content: center; align-items: center; max-width:1000px">
                <div class="card-group" style="display:flex; justify-content: center; row-gap: 3ch;">
                    <?php if (isset($items)): ?>
                        <?php foreach ($items as $index => $item): ?>

                            <div class="card"
                                style="background-color:#1E1E1E !important; padding:10px; cursor:pointer;border:1px white solid;border-color: #6c757d; border-radius:8px; margin:20px; margin-top:0px; margin-bottom:0px;">
                                <div class="numberCircle" style="margin-right:0px;"><?= $item['quantity'] ?></div>

                                <div onclick="window.location.href='/details?itemID=<?= $item['item']->getId() ?>&fromCart=true'">
                                    <img class="card-img-top" src="public/images/<?= $item['item']->getImageLink() ?>"
                                        alt="Card image cap" style="background-color:white;">
                                    <div class="card-body" style="margin-bottom:20px;">

                                        <h5 class="card-title">
                                            <?= $item['item']->getName() ?>
                                        </h5>
                                        <p class="card-text">$<?= $item['item']->getBuyPrice() ?></p>
                                        <p class="card-text"><small class="text-muted">Poids : <?= $item['item']->getItemWeight() ?>
                                                kg<br></small></p>
                                    </div>
                                </div>

                                <div style="display:flex; flex-direction: row; ">

                                    <a type="button" href="/cart?removeItem=true&itemID=<?= $item['item']->getID() ?>" class="btn btn-secondary" style="color:white; font-weight:bold;background-color: transparent; border-color:white; border-radius:10px; width:130px;">-</a>
                                    <div style="margin: 5px;"></div>
                                    <a type="button" href="/cart?addItem=true&itemID=<?= $item['item']->getId() ?>" class="btn btn-secondary" style="color:white; font-weight:bold;background-color: transparent; border-color:white; border-radius:10px; width:130px;">+</a>

                                </div>
                            </div>

                        <?php endforeach; ?>
                    <?php else: ?>
                        <div style=" display:flex; justify-content: center; flex-direction: column; align-items:center; ">
                            <!-- todo justify center -->
                            <span style="font-size:30px;">Rien a afficher ici </span> <br>
                            <a type="button" href="/shop" class="btn btn-secondary" style="margin-top:20px;">Retourner au shop</a>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>

        <!-- section sommaire -->

        <div>
            <?php if (isset($items)): ?>
                <div id="form-check-section"
                    style="display:flex; flex-direction: column; width:450px;padding:16px; border:1px #6c757d solid; row-gap: 5px; height:800px; ">

                    <p style="font-size:30px">Sommaire de l'achat</p>

                    <?php foreach ($items as $index => $item): ?>
                        <div class="row justify-content-between" style="margin-bottom:10px;">
                            <div class="col-4" style="width:auto;">
                                <?= $item['item']->getName() ?> x <?= $item['quantity'] ?>
                            </div>
                            <div class="col-4" style="width:auto;">
                                $<?= $item['item']->getBuyPrice() ?> • <?= $item['item']->getItemWeight() ?>kg
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <hr />

                    <div class="row justify-content-between" style="font-size:30px; margin-bottom: 20px;">
                        <div class="col-4" style="width:auto;">
                            Total
                        </div>
                        <div class="col-4" style="width:auto;">
                            $<?= $totalPrice ?> • <?= $totalWeight ?>kg
                        </div>
                    </div>
                    <?php if($totalWeight + $model->totalWeight($_SESSION['playerID']) > $user->getMaxWeight()): ?>
                        <p style="color:red;">Votre sac est trop lourd. Vous allez perdre de la dexteriter si vous achetez ces items.</p>
                    <?php endif ?>
                    <a type="button" href="/cart?buy=true" style="width:420px; height:55px; font-size:20px;" class="btn btn-secondary">Checkout</a>
                </div>
            <?php endif ?>
        </div>

    </div>
</div>
</div>
<?php
require 'views/partials/footer.php';
?>
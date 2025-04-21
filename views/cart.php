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

    #sommaire {
        width: 480px;
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

    .card-group .card {
        max-width: 325px !important;
        min-width: 270px !important;
        min-height: 400px !important;
        border: 1px;
        transition: all 0.5s ease;
    }

    .card {
        min-width: 300px !important;
    }

    .card-group .card:hover {
        transform: scale(1.05);
        box-shadow: 0 0 3px white;
    }

    .card-img-top {
        max-height: 300px;
        min-height: 250px;
        aspect-ratio: 2/3;
    }

    .masonry {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
        grid-auto-rows: 45px;
        gap: 5px;
        row-gap: 400px;
        height: 100%;
        width: 100%;
        margin-bottom: 400px;
    }



    #shopItems {
        flex-direction: column;
        justify-content: center;
        width: 40%;
        column-gap: 40px;
        display: flex;
    }



    #allShop {
        display: flex;
        justify-content: center;
        column-gap: 40px;
        height: 100%;
    }

    @media only screen and (max-width: 1200px) {
        .masonry {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
            grid-auto-rows: 45px;
            gap: 5px;
            row-gap: 400px;
            height: 100%;
            width: 100%;

            margin-bottom: 400px;
        }



        #formCrit {
            display: flex;
            flex-direction: row;
            column-gap: 20px;
            justify-content: center;
            align-items: center;
        }

        #form-check-section {
            display: flex;
            flex-direction: column;
            width: 100%;
            padding: 16px;
            border: 1px #6c757d solid;
            row-gap: 5px;
            height: 425px;
        }

        #main-form {
            width: 50%;

        }

        #taggies {
            display: flex;
            flex-direction: row;
            column-gap: 8px;
            margin-left: 0px;
        }
    }

    @media only screen and (max-width: 1000px) {
        .masonry {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
            grid-auto-rows: 45px;
            gap: 5px;
            row-gap: 400px;
            height: 100%;
            width: 80%;
            padding-left: 30px;
            justify-content: center;
            align-items: center;
            margin-bottom: 400px;
        }

        #sommaire {
            width: 90%;
        }

        #carty {
            display: flex;
            justify-content: center;
            flex-direction: column;
            column-gap: 100px;

        }


        #allShop {
            display: flex;
            flex-direction: column;
            column-gap: 20px;
            row-gap: 20px;
            justify-content: center;
            align-items: center;
        }

        #formCrit {
            display: flex;
            flex-direction: row;
            column-gap: 20px;
            justify-content: center;
            align-items: center;
        }

        #form-check-section {
            display: flex;
            flex-direction: column;
            width: 100%;
            padding: 16px;
            border: 1px #6c757d solid;
            row-gap: 5px;
            height: 425px;
        }

        #main-form {
            width: 50%;

        }

        #shopItems {

            justify-content: center;
            width: 100%;
        }

        #formCrit {
            flex-direction: column;
            row-gap: 10px;
        }
    }

    .item {
        width: 100%;
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
        grid-row: span 10;
        align-content: center;
    }

    .item:hover {
        transform: translateY(-10px);
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
    <div id="allShop">
        <div id="shopItems">

            <!-- cards -->


            <div class="masonry">


                <?php if (isset($items)): ?>
                    <?php foreach ($items as $index => $item): ?>


                        <div class="card"
                            style="background-color:#1E1E1E !important; padding:20 10px; width:100% !important;height:100% !important; cursor:pointer;border:1px white solid;border-color: #6c757d; border-radius:8px; margin:20px; margin-top:0px; margin-bottom:0px;">
                            <div class="numberCircle" style="margin-right:0px;"><?= $item['quantity'] ?></div>
                            <img class="card-img-top" src="public/images/<?= $item['item']->getImageLink() ?>"
                                alt="Card image cap" style="background-color:white;">
                            <div class="card-body" style="margin-bottom:20px;">

                                <h5 class="card-title">
                                    <?= $item['item']->getName() ?>
                                </h5>
                                <p class="card-text">$<?= $item['item']->getBuyPrice() ?></p>
                                <p class="card-text"><small class="text-muted">Poids : <?= $item['item']->getItemWeight() ?>
                                        kg<br></small></p>
                                <div style="display:flex; flex-direction: col; justify-content: center; ">

                                    <a type="button" href="/cart?removeItem=true&itemID=<?= $item['item']->getID() ?>"
                                        class="btn btn-secondary"
                                        style="color:white; font-weight:bold;background-color: transparent; border-color:white; border-radius:10px; width:30%;">-</a>
                                    <div style="margin: 5px;"></div>
                                    <a type="button" href="/cart?addItem=true&itemID=<?= $item['item']->getId() ?>"
                                        class="btn btn-secondary"
                                        style="color:white; font-weight:bold;background-color: transparent; border-color:white; border-radius:10px; width:30%;">+</a>
                                    <div style="margin: 5px;"></div>
                                    <a type="button"
                                        href="/cart?clearItem=true&itemID=<?= $item['item']->getId() ?>&itemQt=<?= $item['quantity'] ?>"
                                        class="btn btn-secondary"
                                        style="color:white; font-weight:bold;background-color: transparent; border-color:white; border-radius:10px; width:30%;"><i
                                            class="bi bi-trash"></i></a>

                                </div>
                            </div>

                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div style=" display:flex; justify-content: center; flex-direction: column; align-items:center; ">
                        <!-- todo justify center -->
                        <span style="font-size:30px;">Rien a afficher ici </span> <br>
                        <a type="button" href="/shop" class="btn btn-secondary" style="margin-top:20px;">Retourner au
                            shop</a>
                    </div>
                <?php endif ?>
            </div>

        </div>

        <!-- section sommaire -->

        <div id="sommaire">
            <?php if (isset($items)): ?>
                <div id="form-check-section"
                    style="display:flex; flex-direction: column; width:100%;padding:16px; border:1px #6c757d solid; row-gap: 5px; height:800px; ">

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
                    <?php if ($totalWeight + $model->totalWeight($_SESSION['playerID']) > $user->getMaxWeight()): ?>
                        <p style="color:red;">Votre sac est trop lourd. Vous allez perdre de la dexteriter si vous achetez des
                            items</p>
                    <?php endif ?>
                    <a type="button" href="/cart?buy=true" style="width:100%; height:55px; font-size:20px;"
                        class="btn btn-secondary">Checkout</a>
                    <a type="button" href="/cart?clearCart=true" style="width:100%; height:55px; font-size:20px;"
                        class="btn btn-warning">Clear Cart</a>
                </div>
            <?php endif ?>
        </div>

    </div>
</div>
</div>
<?php
require 'views/partials/footer.php';
?>
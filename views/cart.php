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

<!-- todo add clear items => set querry ?clearItems = true -->

<div>
    <div style="display:flex; justify-content: center; flex-direction:column; align-items:center; margin-bottom:30px;">
        <p style="margin:0px; font-size:23px; font-weight: bold;"> Votre panier </p>
        <p style="font-size:18px;"> <?= isset($items) ? '14 items' : '0 items' ?> </p>
    </div>
    <div style="display:flex; justify-content: center; flex-direction: row;">
        <div
            style="display:flex; justify-content: center; align-items: center;height:auto; margin-right:<?= isset($items) ? '70px' : '0px' ?>;">

            <!-- cards -->

            <div class="card-group"
                style="display:flex; justify-content: center; align-items: center; row-gap: 3ch;max-width:700px">
                <?php if (isset($items)): ?>
                    <?php foreach ($items as $index => $item): ?>
                        <div class="card"
                            style="background-color:#1E1E1E !important; padding:10px; cursor:pointer;border:1px white solid;border-color: #6c757d; border-radius:8px; margin:20px; margin-top:0px; margin-bottom:0px; min-width:300px; min-height:450px;">

                            <img class="card-img-top"
                                src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ-YtnuV2n_8xuMZbIQ8voSyC4hjGBN6DLC8w&s"
                                alt="Card image cap" onclick="window.location.href='/details?itemID=1';">
                            <!-- do php details todo && fix click -->
                            <div class="card-body" style="margin-bottom:20px; padding:10px;">

                                <h5 class="card-title">
                                    Sword1 x 2
                                </h5>
                                <p class="card-text" style="margin:0px;">$700</p>
                                <p class="card-text">
                                    <small class="text-muted">Poids : 10 kg<br></small>
                                </p>
                                <div style="display:flex; flex-direction: row; ">

                                    <input type="button" value="-" class="button-minus border icon-shape icon-sm mx-1 "
                                        data-field="quantity"
                                        style="color:white; border:none; font-weight:bold;background-color: transparent; border-radius:10px; width:130px;"
                                        href="/cart?removeItem=true">

                                    <input type="button" value="+" class="button-plus border icon-shape icon-sm "
                                        style="color:white; border:none; font-weight:bold;background-color: transparent; border-radius:10px; width:130px; margin-left:10px;"
                                        data-field="quantity" href="/cart?removeItem=true">
                                </div>


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

        <div>
            <?php if (isset($items)): ?>
                <div id="form-check-section"
                    style="display:flex; flex-direction: column; width:450px;padding:16px; border:1px #6c757d solid; row-gap: 5px; height:800px; ">

                    <p style="font-size:30px">Sommaire de l'achat</p>
                    <div class="row justify-content-between" style="margin-bottom:10px;">
                        <div class="col-4" style="width:auto;">
                            Sword x 1
                        </div>
                        <div class="col-4" style="width:auto;">
                            $100 • 100kg
                        </div>
                    </div>
                    <div class="row justify-content-between" style="margin-bottom:10px;">
                        <div class="col-4" style="width:auto;">
                            One of two columns
                        </div>
                        <div class="col-4" style="width:auto;">
                            One of two columns
                        </div>
                    </div>
                    <div class="row justify-content-between" style="margin-bottom:10px;">
                        <div class="col-4" style="width:auto;">
                            One of two columns
                        </div>
                        <div class="col-4" style="width:auto;">
                            One of two columns
                        </div>
                    </div>
                    <hr />
                    <div class="row justify-content-between" style="font-size:30px; margin-bottom: 20px;">
                        <div class="col-4" style="width:auto;">
                            Total
                        </div>
                        <div class="col-4" style="width:auto;">
                            $10000 • 10kg
                        </div>
                    </div>
                    <a type="button" href="/cart?buy=true" style="width:420px; height:55px; font-size:20px;"
                        class="btn btn-secondary">Checkout</a>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>
</div>
<?php
require 'views/partials/footer.php';
?>
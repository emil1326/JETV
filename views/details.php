<?php

require 'views/partials/head.php';
require 'views/partials/header.php';

// error codes
$peuPasUse ?? false;
$peuPasVendre ?? false;
$peuPasAcheter ?? false;
$peuPasVendre ?? false;

// vals

$inShop ?? false;

?>
<link rel="stylesheet" href="public/css/details.css">

<div style="display:flex; justify-content: center; flex-direction: column;align-items:center;">

    <div class="card mb-3"
        style="background-color:#1E1E1E !important; padding:10px;border:none;  margin:20px; margin-top:0px; margin-bottom:0px; ">
        <div class="row g-0">
            <div class="col-md-4" style="width:50%; max-height:325px; ">
                <img src="public/images/<?= $item->getImageLink() ?>"
                    class="img-fluid rounded-start" alt="..." style="width:100%;height:110%;aspect-ratio: auto; background-color: white;">
            </div>
            <div class=" col-md-8" style="padding-left:30px; width:50%; max-height:325px; ">
                <div class="card-body" style="max-height:325px !important;">
                    <h5 class="card-title" style="font-weight:bold;"><?= $item->getName() ?></h5>
                    <p class="card-text" style="font-size:50px; font-weight: bold;"><span
                            style="font-size:30px; ">$</span><?= $item->getBuyPrice() ?></p>
                    <p class="card-text"><small class="text-muted"><?= $item->getDescription() ?></small></p>
                    <?php if ($auth): ?>
                        <?php if ($inShop): ?>
                            <!-- if is in shop -->
                            <button class="btn btn-outline-secondary " type="button"
                                style="margin-right:10px; width:100%; margin: 5px; border : none; border-radius:8px;padding-top:4px; background-color: #303030;"
                                data-bs-toggle="modal" data-bs-target="#exampleModalCenter"><a class="buttonst "
                                    style="color:white;">Acheter</a>
                            </button>
                        <?php else: ?>

                            <button class="btn btn-outline-secondary " type="button"
                                style="margin-right:10px; width:100%; margin: 5px; border : none; border-radius:8px;padding-top:4px; background-color: #303030;"
                                data-bs-toggle="modal" data-bs-target="#sellModal"><a class="buttonst "
                                    style="color:white;">Vendre</a>
                            </button>
                            <?php if (ucfirst(get_class($item))=="Meds" || ucfirst(get_class($item))=="Food"): ?>
                                <a type="button" href="/details?use=1&itemID=<?= $item->getId() ?>&isPlayer" class="btn btn-secondary"
                                style="color:white; font-weight:bold;background-color: transparent; border-color:white; border-radius:10px; width:130px;">Use Item</a>
                            <?php endif ?>
                        <?php endif ?>
                    <?php endif ?>

                    <span class="badge bg-secondary" style="width:100px; font-size:15px; height:30px; margin-left:0px; margin-top:20px; background-color:#434343 !important;">
                        <?= ucfirst(get_class($item)) ?>
                    </span>

                    <p class="card-text"><small class="text-muted"><?= $item->getItemWeight() ?> kg</small></p>
                    <p class="card-text"><small class="text-muted"><?= $qt ?> Exemplaires</small></p>

                    <?php if(isset($peuPasUse)):?>
                        <p class="card-text"><small class="text-danger">Vous ne pouvez pas utiliser cet item</small></p>
                    <?php endif ?>
                    <?php if(isset($peuPasVendre)):?>
                        <p class="card-text"><small class="text-danger">Vous ne pouvez pas vendre cet item</small></p>
                    <?php endif ?>
                    <?php if(isset($peuPasAcheter)):?>
                        <p class="card-text"><small class="text-danger">Vous ne pouvez pas acheter cet item</small></p>
                    <?php endif ?>
                    <!-- TODO itemquantity
                    <p class="card-text"><small class="text-muted"></small></p>
                    -->
                    <!--
                    <div
                        style="display:flex; flex-direction: column; background-color: #303030; margin-top:10px; padding:15px; border-radius:8px; border:1px  #6c757d solid;">
                        <span class="badge bg-secondary" style="width:100px; font-size:15px; height:30px; margin-left:10px; background-color:#434343 !important;">Arme</span>
                        <div class="rating-card">
                            <div class=" star-rating animated-stars"
                                style="display:flex; flex-direction:row; justify-content:flex-start">
                                <?php $etoiles = 4; ?>
                                <?php for ($i = 0; $i < 5; $i++): ?>
                                    <input type="radio" id="star<?= $i ?>" name="rating" value="<?= $i ?>">
                                    <label for="star<?= $i ?>" class="bi bi-star-fill"
                                        style="color:<?= $i >= $etoiles ? "#757575" : "white" ?>; font-size: 18px; padding: 0 6px; text-align:center;">
                                        </br>1</label>

                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                    -->
                </div>
            </div>
        </div>
    </div>
    <div style="background-color: #303030; width:100%; margin-top:60px; padding-bottom:80px; margin-bottom:200px;">
        <div class="container" style="margin-top:60px; background-color: #303030;">
            <div class="row">
                <div class="col-6">
                    <h3 class="mb-3" style="font-size:20px;">Attributs</h3>
                </div>
                <?php if (count($attributes) >= 4): ?>
                    <div class="col-6 text-right">
                        <a class="btn btn-secondary mb-3 mr-1" href="#carouselExampleIndicators2" role="button"
                            data-slide="prev" style="background-color:#303030; border:none;">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                        <a class="btn btn-secondary mb-3" href="#carouselExampleIndicators2" role="button" data-slide="next"
                            style="background-color:#303030; border:none;">
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                <?php endif; ?>
                <div class="col-12">
                    <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">

                        <div class="carousel-inner">
                            <?php if (count($attributes) == 4): ?>
                                <?php foreach (array_chunk($attributes, 2, true) as $index => $attributeChunk): ?>
                                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                        <div class="row">
                                            <?php foreach ($attributeChunk as $attributeName => $attributeValue): ?>
                                                <div class="col-md-6 mb-3">
                                                    <div class="card cardCar">
                                                        <div class="card-body">
                                                            <h4 class="card-title">
                                                                <?= htmlspecialchars($attributeName) ?>
                                                            </h4>
                                                            <p class="card-text">
                                                                <?= htmlspecialchars($attributeValue) ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <?php if (count($attributes) <= 3): ?>
                                <div class="row">
                                    <?php foreach ($attributes as $attributeName => $attributeValue): ?>
                                        <div class="col-md-4 mb-3">
                                            <div class="card cardCar">
                                                <div class="card-body">
                                                    <?php if (isset($attributeValue)): ?>
                                                        <h4 class="card-title">
                                                            <?= htmlspecialchars($attributeName) ?>
                                                        </h4>
                                                        <p class="card-text">
                                                            <?= htmlspecialchars($attributeValue) ?>
                                                        </p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- buy -->
    <?php if ($inShop): ?>
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="background-color:#303030;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Ajouter votre quantité</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p style="color:white;"><?= $item->getName() ?> <?= $item->getBuyPrice() ?>$</p>
                                </div>
                                <div class="input-group w-auto justify-content-end align-items-center">
                                    <input type="button" value="-"
                                        class="button-minus border rounded-circle  icon-shape icon-sm mx-1 "
                                        data-field="quantity"
                                        style="color:white; border:none; font-weight:bold;background-color: transparent;">
                                    <input type="number" step="1" max="<?= $qt ?>" value="1" name="quantity"
                                        class="quantity-field border-0 text-center w-25"
                                        style="background-color:transparent; color:white; font-size:20px;" disabled>
                                    <input type="button" value="+"
                                        class="button-plus border rounded-circle icon-shape icon-sm "
                                        style="color:white; border:none; font-weight:bold;background-color: transparent;"
                                        data-field="quantity">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form method="GET">
                            <input type="hidden" name="itemID" value="<?= $item->getId() ?>">
                            <input type="hidden" name="quantity" value="1" id="quantityInput">
                            <input type="hidden" name="buy" value="1">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary" style="background-color: white; color:black;"
                                id="liveToastBtn">Ajouter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- sell -->
    <?php else: ?>
        <div class="modal fade" id="sellModal" tabindex="-1" aria-labelledby="modalSell" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="background-color:#303030;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalSell">Vendre votre quantité</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p style="color:white;"><?= $item->getName() ?> <?= $item->getBuyPrice() ?>$</p>
                                </div>
                                <div class="input-group w-auto justify-content-end align-items-center">
                                    <input type="button" value="-"
                                        class="button-minus border rounded-circle icon-shape icon-sm mx-1"
                                        data-field="quantity"
                                        style="color:white; border:none; font-weight:bold;background-color: transparent;">
                                    <input type="number" step="1" max="<?= $qt ?>" value="1" name="quantity"
                                        class="quantity-field border-0 text-center w-25"
                                        style="background-color:transparent; color:white; font-size:20px;" disabled>
                                    <input type="button" value="+"
                                        class="button-plus border rounded-circle icon-shape icon-sm"
                                        style="color:white; border:none; font-weight:bold;background-color: transparent;"
                                        data-field="quantity">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form method="GET"> <!-- Add action to sell the item -->
                            <input type="hidden" name="itemID" value="<?= $item->getId() ?>">
                            <input type="hidden" name="quantity" value="1" id="quantityInput">
                            <input type="hidden" name="sell" value="1">
                            <input type="hidden" name="isPlayer" value="1">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary" style="background-color: white; color:black;" id="sellToastBtn">Vendre</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endif ?>

</div>
<script>
    function incrementValue(e) {
        e.preventDefault();
        var fieldName = $(e.target).data('field');
        var parent = $(e.target).closest('div');
        var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

        if (!isNaN(currentVal) && currentVal < <?= $qt ?>) {
            parent.find('input[name=' + fieldName + ']').val(currentVal + 1);
        } else {
            parent.find('input[name=' + fieldName + ']').val(1);
        }
        document.getElementById('quantityInput').value = currentVal + 1;
    }

    function decrementValue(e) {
        e.preventDefault();
        var fieldName = $(e.target).data('field');
        var parent = $(e.target).closest('div');
        var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

        if (!isNaN(currentVal) && currentVal > 1) {
            parent.find('input[name=' + fieldName + ']').val(currentVal - 1);
        } else {
            parent.find('input[name=' + fieldName + ']').val(1);
        }
        document.getElementById('quantityInput').value = currentVal + 1;
    }

    $('.input-group').on('click', '.button-plus', function(e) {
        incrementValue(e);
    });

    $('.input-group').on('click', '.button-minus', function(e) {
        decrementValue(e);
    });
</script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

<?php
require 'views/partials/footer.php';
?>
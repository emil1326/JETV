<?php

require 'views/partials/head.php';
require 'views/partials/header.php';

// error codes
$peuPasUse;
$peuPasVendre;
$peuPasAcheter;

if (!isset($peuPasUse)) {
    $peuPasUse = false;
}
if (!isset($peuPasVendre)) {
    $peuPasVendre = false;
}
if (!isset($peuPasAcheter)) {
    $peuPasAcheter = false;
}


// vals

$inShop ?? false;

?>
<link rel="stylesheet" href="public/css/details.css">
<style>
    .item-image-container {
        background-repeat: no-repeat;
        background-size: contain;
        background-position: center;
        width: 50%;
        min-height: 250px;
    }

    @media (max-width: 768px) {
        .item-image-container {
            min-height: 200px;
            width: 100%;
        }
    }
</style>
<div style="display:flex; justify-content: center; flex-direction: column;align-items:center;">

    <!-- Card Item Section -->
    <div class="card mb-3" style="background-color:#1E1E1E; padding:10px; border:none; margin:20px 0; width:75%;">
        <div class="row g-0">
            <div class="col-md-4 item-image-container"
                style=" background-image: url('public/images/products/<?= $item->getImageLink() ?>'); background-color: white;">
                <!-- Image moved to background -->
            </div>
            <div class="col-12 col-md-6 p-3">
                <div class="card-body">
                    <h5 class="card-title fw-bold text-white"><?= $item->getName() ?></h5>
                    <p class="card-text" style="font-size:40px; font-weight:bold;"><span
                            style="font-size:20px;">$</span><?= $item->getBuyPrice() ?></p>
                    <p class="card-text"><small class="text-muted"><?= $item->getDescription() ?></small></p>

                    <?php if ($auth): ?>
                        <?php if ($inShop): ?>
                            <button class="btn w-100 my-2"
                                style="background-color:#303030; color:white; border:none; border-radius:8px;"
                                data-bs-toggle="modal" data-bs-target="#exampleModalCenter">Acheter</button>
                        <?php elseif ($qt > 1): ?>
                            <button class="btn w-100 my-2"
                                style="background-color:#303030; color:white; border:none; border-radius:8px;"
                                data-bs-toggle="modal" data-bs-target="#sellModal">Vendre</button>
                            <?php if (ucfirst(get_class($item)) == "Meds" || ucfirst(get_class($item)) == "Food"): ?>
                                <a href="/details?use=1&itemID=<?= $item->getId() ?>&isPlayer"
                                    class="btn btn-outline-light w-100">Utiliser</a>
                            <?php endif ?>
                        <?php endif ?>
                    <?php endif ?>

                    <span class="badge bg-secondary mt-3"
                        style="background-color:#434343 !important; font-size:14px;"><?= ucfirst(get_class($item)) ?></span>
                    <p class="card-text mt-2 text-muted">Poids : <?= $item->getItemWeight() ?> kg</p>
                    <p class="card-text text-muted">Quantité : <?= $qt ?> exemplaires</p>

                    <?php if ($peuPasUse): ?>
                        <p class="text-danger">Vous ne pouvez pas utiliser cet item</p>
                    <?php endif ?>
                    <?php if ($peuPasVendre): ?>
                        <p class="text-danger">Vous ne pouvez pas vendre cet item</p>
                    <?php endif ?>
                    <?php if ($peuPasAcheter): ?>
                        <p class="text-danger">Vous ne pouvez pas acheter cet item</p>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Attributes Carousel -->
    <div style="background-color:#303030; width:100%; min-height: 300px ; padding:40px 0; ">
        <div class="container" style="max-width:75%">
            <h3 class="text-white mb-3" style="font-size:20px;">Attributs</h3>

            <?php if (count($attributes) >= 4): ?>
                <div class="text-end mb-2">
                    <a class="btn btn-secondary btn-sm" href="#carouselExampleIndicators2" data-slide="prev"
                        style="background-color:#303030; border:none;"><i class="fa fa-arrow-left"></i></a>
                    <a class="btn btn-secondary btn-sm" href="#carouselExampleIndicators2" data-slide="next"
                        style="background-color:#303030; border:none;"><i class="fa fa-arrow-right"></i></a>
                </div>
            <?php endif; ?>

            <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <?php if (count($attributes) == 4): ?>
                        <?php foreach (array_chunk($attributes, 2, true) as $index => $attributeChunk): ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                <div class="row">
                                    <?php foreach ($attributeChunk as $attributeName => $attributeValue): ?>
                                        <div class="col-12 col-md-6 mb-3">
                                            <div class="card bg-dark text-white"
                                                style="background:transparent !important; border:none !important;">
                                                <div class="card-body">
                                                    <h5 class="card-title" style="font-size:18px;">
                                                        <?= htmlspecialchars($attributeName) ?>
                                                    </h5>
                                                    <p class="card-text" style="font-size:16px;">
                                                        <?= htmlspecialchars($attributeValue) ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="row">
                            <?php foreach ($attributes as $attributeName => $attributeValue): ?>
                                <div class="col-12 col-md-4 mb-3">
                                    <div class="card bg-dark text-white"
                                        style="background:transparent !important; border:none !important;">
                                        <div class="card-body">
                                            <h5 class="card-title" style="font-size:22px;">
                                                <?= htmlspecialchars($attributeName) ?>
                                            </h5>
                                            <p class="card-text" style="font-size:18px;">
                                                <?= htmlspecialchars($attributeValue) ?>
                                            </p>
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

<style>
    @media (max-width: 768px) {
        .card-title {
            font-size: 18px;
        }

        .card-text {
            font-size: 14px;
        }
    }
</style>


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
                                    style="background-color:transparent; color:white; font-size:20px;">
                                <input type="button" value="+" class="button-plus border rounded-circle icon-shape icon-sm "
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
                                    class="button-minus border rounded-circle icon-shape icon-sm mx-1" data-field="quantity"
                                    style="color:white; border:none; font-weight:bold;background-color: transparent;">
                                <input type="number" step="1" max="<?= $qt ?>" value="1" name="quantity"
                                    class="quantity-field border-0 text-center w-25"
                                    style="background-color:transparent; color:white; font-size:20px;">
                                <input type="button" value="+" class="button-plus border rounded-circle icon-shape icon-sm"
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
                        <input type="hidden" name="sell" value="1">
                        <input type="hidden" name="isPlayer" value="1">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary" style="background-color: white; color:black;"
                            id="sellToastBtn">Vendre</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>


<div id='commentSection'>
    <form id='commentSection-form' method="post">
        <label for='content'>Commentaire</label>
        <textarea type='text' name='content' id='commentSection-form-content'></textarea>

        <input type='submit'>
    </form>

    <div>
        <?php if (isset($commentsData) && $commentsData != null): ?>
            <?php foreach ($commentsData as $comment): ?>
                <div style="background-color: #303030; height: 120px; margin: 20px;">
                    <div style="display: flex; margin: 20px; padding-top: 20px;">
                        <img src="public/images/users/<?= $comment['userProfileImage']; ?>" class="rounded-circle"
                            style="width: 30px; border-radius:10% !important; cursor:pointer;" alt="Avatar" />
                        <p style="margin-left: 10px; margin-right: 10px; text-align: center; margin-top: auto; margin-bottom: auto;"><?= $comment['username']; ?></p>
                        <img src="public/images/ui/stars_<?= $comment['starCount'] ?>" class="rounded-circle"
                            style="height: 30px; border-radius:10% !important; cursor:pointer;" alt="Avatar" />
                    </div>
                    <div style="margin-left: 20px;">
                        <p><?= $comment['comment']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>


<script>
    $("#commentSection-form").on('submit', (e) => {

    });

    function incrementValue(e) {
        e.preventDefault();
        const button = $(e.target);
        const fieldName = button.data('field');
        const parent = button.closest('div');
        const input = parent.find(`input[name='${fieldName}']`);
        const currentVal = parseInt(input.val(), 10);

        if (!isNaN(currentVal) && currentVal < <?= $qt ?>) {
            input.val(currentVal + 1);
            document.getElementById('quantityInput').value = currentVal + 1; // Update hidden input
        } else {
            input.val(1);
            document.getElementById('quantityInput').value = 1;
        }
    }

    function decrementValue(e) {
        e.preventDefault();
        const button = $(e.target);
        const fieldName = button.data('field');
        const parent = button.closest('div');
        const input = parent.find(`input[name='${fieldName}' ]`);
        const currentVal = parseInt(input.val(), 10);

        if (!isNaN(currentVal) && currentVal > 1) {
            input.val(currentVal - 1);
            document.getElementById('quantityInput').value = currentVal - 1; // Update hidden input
        } else {
            input.val(1);
            document.getElementById('quantityInput').value = 1;
        }
    }

    function setValue(e) {
        e.preventDefault();
        const input = $(e.target);
        const fieldName = input.data('field');
        const parent = input.closest('div');
        const currentVal = parseInt(input.val(), 10);

        if (!isNaN(currentVal) && currentVal > 0) {
            document.getElementById('quantityInput').value = currentVal; // Update hidden input
        } else {
            input.val(1);
            document.getElementById('quantityInput').value = 1;
        }
    }

    // Attach event listeners using event delegation
    $(document).on('click', '.button-plus', function(e) {
        incrementValue(e);
    });

    $(document).on('click', '.button-minus', function(e) {
        decrementValue(e);
    });

    $(document).on('change', '.quantity-field', function(e) {
        setValue(e);
    });
</script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

<?php
require 'views/partials/footer.php';
?>

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

    .card-img-top {
        max-height: 300px;
        min-height: 250px;
        aspect-ratio: 2/3;
    }
</style>
<div style="display:flex; flex-direction:row; column-gap: 20px;justify-content:center;">

    <form method='GET'>

        <!--  TODO: Add Name in form (search filters) -->

        <div id="form-check-section"
            style="display:flex; flex-direction: column; width:240px;padding:16px; border:1px #6c757d solid; row-gap: 5px; height:455px; ">

            <p>Types</p>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="armes" name="type_arme"
                    <?= updateCheckField('arme', $types ?? []) ?>>
                <label class="form-check-label" for="armes">
                    Armes
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="armures" name="type_armure"
                    <?= updateCheckField('armure', $types ?? []) ?>>
                <label class="form-check-label" for="armures">
                    Armures
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="meds" name="type_med"
                    <?= updateCheckField('med', $types ?? []) ?>>
                <label class="form-check-label" for="meds">
                    Médicaments
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="food" name="type_food"
                    <?= updateCheckField('food', $types ?? []) ?>>
                <label class="form-check-label" for="food">
                    Nourriture
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="munitions" name="type_mun"
                    <?= updateCheckField('mun', $types ?? []) ?>>
                <label class="form-check-label" for="munitions">
                    Munitions
                </label>
            </div>

            <br>

            <div data-mdb-input-init class="form-outline">
                <label for="postfix" class="form-label" style="display: inline;">Price Range</label>
                <input id="postfix"
                    value="<?= $filters['price_min'] ?? '' ?>"
                    type="number" id="form2" name="price_min" class="form-control" placeholder="Min" style="height:30px;" />
            </div>

            <div data-mdb-input-init class="form-outline">
                <input id="postfix"
                    value="<?= $filters['price_max'] ?? '' ?>"
                    type="number" id="form2" name="price_max" class="form-control" placeholder="Max" style="height:30px;" />
            </div>
            <!-- <label for="customRange2" class="form-label">Price range</label>
            <input type="range" class="form-range" min="0" max="5" id="customRange2"> -->

            <!--
            <div class="form-group" style="margin-bottom: 20px;">
                <label for="exampleFormControlSelect1">Étoiles</label>
                <select class="form-control" id="exampleFormControlSelect1">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
            </div>
            -->

            <br>

            <input type='submit' value='Search'>
        </div>

    </form>



    <div style="display:flex; flex-direction: column; max-width:1000px; row-gap: 40px;">
        <div style="display:flex; flex-direction: row; column-gap: 20px;  justify-content:center; align-items: center;">
            <p style="margin-bottom:0px; margin-right:0px;"> Nom : </p>
            <div class="input-group rounded"
                style="width:486px; background-color:#1E1E1E; border:1px  #6c757d solid; border-radius:100px !important; color:white;">
                <input id="search" type="search" class="form-control rounded searchy" placeholder="Search"
                    aria-label="Search"
                    style="background-color:#1E1E1E; border:0px;border-radius:100px !important; color:white;"
                    aria-describedby="search-addon" />
                <span class="input-group-text border-0" id="search-addon"
                    style="border-radius:100px !important; background-color:#1E1E1E; color:white;">
                    <i class="fas fa-search"></i>
                </span>
            </div>
            <div style="display:flex; flex-direction: row; column-gap:8px; margin-left:50px;">

                <input type="radio" class="btn-check" name="options" id="option1" autocomplete="off" checked
                    style="border-radius:100px">
                <label class="btn btn-secondary" for="option1">Prix</label>

                <input type="radio" class="btn-check" name="options" id="option2" autocomplete="off">
                <label class="btn btn-secondary" for="option2">Utilité</label>

                <input type="radio" class="btn-check" name="options" id="option3" autocomplete="off">
                <label class="btn btn-secondary" for="option3">Poids</label>

                <input type="radio" class="btn-check" name="options" id="option4" autocomplete="off">
                <label class="btn btn-secondary" for="option4">Quantité</label>
            </div>
        </div>

        <!-- Card -->

        <div style="display:flex; justify-content: center; align-items: center; max-width:1000px">
            <div class="card-group" style="display:flex; justify-content: center; row-gap: 3ch;">
                <?php if (isset($items)): ?>
                    <?php foreach ($items as $index => $item): ?>

                        <div class="card"
                            style="background-color:#1E1E1E !important; padding:10px; cursor:pointer;border:1px white solid;border-color: #6c757d; border-radius:8px; margin:20px; margin-top:0px; margin-bottom:0px;"
                            onclick="window.location.href='/details?itemID=<?= $item['item']->getId() ?>'">
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
                            </div>
                        </div>

                    <?php endforeach; ?>
                <?php else: ?>
                    <div style="margin-right: 20vw;"> <!-- todo justify center -->
                        Rien a afficher ici <br>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>

<script>
    const inputMin = document.querySelector("input[name='price_min']");
    const inputMax = document.querySelector("input[name='price_max']");

    function allowOnlyIntegers(input) {
        input.addEventListener("input", (e) => {
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
        });
    }

    allowOnlyIntegers(inputMin);
    allowOnlyIntegers(inputMax);
</script>
<?php
require 'views/partials/footer.php';
?>

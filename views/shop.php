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
<div style="display:flex; flex-direction:row; column-gap: 20px;justify-content:center;">

    <div id="form-check-section"
        style="display:flex; flex-direction: column; width:240px;padding:16px; border:1px #6c757d solid; row-gap: 5px; height:305px; ">

        <p>Types</p>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="armes" name="armes">
            <label class="form-check-label" for="armes">
                Armes
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="armures" name="armures">
            <label class="form-check-label" for="armures">
                Armures
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="meds" name="meds">
            <label class="form-check-label" for="meds">
                Médicaments
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="food" name="food">
            <label class="form-check-label" for="food">
                Nourriture
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="munitions" name="munitions">
            <label class="form-check-label" for="munitions">
                Munitions
            </label>
        </div>
        <label for="customRange2" class="form-label">Example range</label>
        <input type="range" class="form-range" min="0" max="5" id="customRange2">
    </div>



    <div style="display:flex; flex-direction: column; max-width:1000px; row-gap: 40px;">
        <div style="display:flex; flex-direction: row; col-gap: 10px;column-gap: 20px;  justify-content:center; ">
            <div class="input-group rounded"
                style="width:286px; background-color:#1E1E1E; border:1px  #6c757d solid; border-radius:100px !important; color:white;">
                <input id="search" type="search" class="form-control rounded searchy" placeholder="Search"
                    aria-label="Search"
                    style="background-color:#1E1E1E; border:0px;border-radius:100px !important; color:white;"
                    aria-describedby="search-addon" />
                <span class="input-group-text border-0" id="search-addon"
                    style="border-radius:100px !important; background-color:#1E1E1E; color:white;">
                    <i class="fas fa-search"></i>
                </span>
            </div>

            <div style="display:flex; flex-direction: row; align-items: center;">
                <p style="margin-bottom:0px; margin-right:10px;"> Étoiles : </p>
                <div class="input-group rounded"
                    style="width:120px; background-color:#1E1E1E; border:1px  #6c757d solid; border-radius:100px !important; color:white;">

                    <input id="etoiles" type="search" class="form-control rounded searchy" placeholder="Search"
                        aria-label="Search"
                        style="background-color:#1E1E1E; border:0px;border-radius:100px !important; color:white;"
                        aria-describedby="search-addon" />
                    <span class="input-group-text border-0" id="search-addon"
                        style="border-radius:100px !important; background-color:#1E1E1E; color:white;">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
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
        <div style="display:flex; justify-content: center; align-items: center; max-width:1000px">
            <div class="card-group" style="display:flex; justify-content: center; row-gap: 3ch;">
                <?php if (isset($items)): ?>
                    <?php foreach ($items as $index => $item): ?>

                        <div class="card"
                            style="background-color:#1E1E1E !important; padding:10px; cursor:pointer;border:1px white solid;border-color: #6c757d; border-radius:8px; margin:20px; margin-top:0px; margin-bottom:0px;"
                            onclick="window.location.href='/details?itemID=<?= $item['item']->getId() ?>';">
                            <div class="numberCircle" style="margin-right:0px;"><?= $item['quantity'] ?></div>
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

                    <?php endforeach; ?>
                <?php endif ?>
            </div>

        </div>
    </div>

</div>

<?php
require 'views/partials/footer.php';
?>

<script>
    $(function() {
        $("#form-check-section > div > input").change(function(e) {
            e.preventDefault();
            var value = $(this).prop("checked");
            var key = $(this).prop("id");
            var _data = {
                key: key,
                value: value,
            };
            console.log(_data);
            $.ajax({
                type: "POST",
                url: "controllers/shop.php",
                dataType: "json",
                data: _data,
                error: function(response) {
                    console.log("Response:", response);
                },
            });
        });
    });
</script>

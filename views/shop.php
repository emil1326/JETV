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
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        grid-auto-rows: 45px;
        gap: 5px;

        width: 100%;
        margin: 0 auto;
    }

    #allShop {
        display: flex;
        flex-direction: row;
        column-gap: 20px;
        justify-content: center;
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
        width: 240px;
        padding: 16px;
        border: 1px #6c757d solid;
        row-gap: 5px;
        height: 425px;
    }

    #taggies {
        display: flex;
        flex-direction: row;
        column-gap: 8px;
        margin-left: 50px;
    }

    #shopitems {
        justify-content: center;
        width: 55%;

    }


    @media only screen and (max-width: 1200px) {
        .masonry {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            grid-auto-rows: 45px;
            gap: 5px;
            width: 100%;

            align-items: center;
            justify-content: center;

            margin: 0 auto;

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
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            grid-auto-rows: 45px;
            gap: 5px;
            width: 100%;
            align-content: center;
            justify-content: center;

            margin: 0 auto;
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

        #shopitems {
            justify-content: center;
            width: 90%;

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
<div id="allShop">

    <form id='main-form' method='GET'>

        <!--  TODO: Add Name in form (search filters) -->

        <div id="form-check-section">

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
                <input id="postfix" value="<?= $filters['price_min'] ?? '' ?>" type="number" id="form2" name="price_min"
                    class="form-control" placeholder="Min" style="height:30px; margin-top: 5px;" />
            </div>

            <div data-mdb-input-init class="form-outline">
                <input id="postfix" value="<?= $filters['price_max'] ?? '' ?>" type="number" id="form2" name="price_max"
                    class="form-control" placeholder="Max" style="height:30px;" />
            </div>
            <br>

            <input type='submit' value='Search'>
        </div>

    </form>




    <div id="shopitems" style="display:flex; flex-direction: column; max-width:1000px; row-gap: 40px;">
        <div id="formCrit">
            <p style="margin-bottom:0px; margin-right:0px;"> Nom : </p>
            <div class="input-group rounded"
                style="width:100%; background-color:#1E1E1E; border:1px  #6c757d solid; border-radius:100px !important; color:white;">
                <input form='main-form' id="search" type="search" name='name' class="form-control rounded searchy"
                    placeholder="Search" value="<?= $filters['name'] ?? '' ?>" aria-label="Search"
                    style="background-color:#1E1E1E; border:0px;border-radius:100px !important; color:white;"
                    aria-describedby="search-addon" />
                <span class="input-group-text border-0" id="search-addon"
                    style="border-radius:100px !important; background-color:#1E1E1E; color:white;">
                    <i class="fas fa-search"></i>
                </span>
            </div>
            <div id='sort-options-radio-buttons' id="taggies">
                <input form='main-form' value='price' type="radio" class="btn-check" name="sort_options" id="option1"
                    autocomplete="off" <?= $filters['sort_options'] == 'price' ? ' checked style="border-radius:100px"' : '' ?>>
                <label class=" btn btn-secondary" for="option1">Prix</label>

                <input form='main-form' value='utility' type="radio" class="btn-check" name="sort_options" id="option2"
                    autocomplete="off" <?= $filters['sort_options'] == 'utility' ? ' checked style="border-radius:100px"' : '' ?>>
                <label class="btn btn-secondary" for="option2">Utilité</label>

                <input form='main-form' value='weight' type="radio" class="btn-check" name="sort_options" id="option3"
                    autocomplete="off" <?= $filters['sort_options'] == 'weight' ? ' checked style="border-radius:100px"' : '' ?>>
                <label class="btn btn-secondary" for="option3">Poids</label>

                <input form='main-form' value='quantity' type="radio" class="btn-check" name="sort_options" id="option4"
                    autocomplete="off" <?= $filters['sort_options'] == 'quantity' ? ' checked style="border-radius:100px"' : '' ?>>
                <label class="btn btn-secondary" for="option4">Quantité</label>
            </div>
        </div>



        <div class="masonry">
            <?php if (isset($items)): ?>
                <?php foreach ($items as $index => $item): ?>
                    <div class="item buttonCursorPointer"
                        onclick="window.location.href='/details?itemID=<?= $item['item']->getId() ?>'">

                        <div class="card"
                            style="background-color:#1E1E1E !important; padding:10px; cursor:pointer;border:1px white solid;border-color: #6c757d; border-radius:8px; margin:20px; margin-top:0px; margin-bottom:0px;">
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

    let form = $('#main-form');

    $('#sort-options-radio-buttons > input').on('click', (e) => {
        form.submit();
    });
</script>
<?php
require 'views/partials/footer.php';
?>
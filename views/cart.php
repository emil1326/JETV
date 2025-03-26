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
        <p style="font-size:18px;"> 14 items </p>
    </div>
    <div style="display:flex; justify-content: center; flex-direction: row;">
        <div style="display:flex; justify-content: center; align-items: center;height:auto; margin-right:80px;">

            <div class="card-group" style="display:flex; justify-content: center; row-gap: 3ch;max-width:700px;">
                <?php for ($i = 0; $i < 6; $i++): ?>
                    <div class="card"
                        style="background-color:#1E1E1E !important; padding:10px; cursor:pointer;border:1px white solid;border-color: #6c757d; border-radius:8px; margin:20px; margin-top:0px; margin-bottom:0px; min-width:300px; min-height:450px;"
                        onclick="window.location.href='/detailstemp';">

                        <img class="card-img-top"
                            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ-YtnuV2n_8xuMZbIQ8voSyC4hjGBN6DLC8w&s"
                            alt="Card image cap">
                        <div class="card-body" style="margin-bottom:20px; padding:10px;">

                            <h5 class="card-title">
                                Sword1 x 2
                            </h5>
                            <p class="card-text" style="margin:0px;">$700</p>
                            <p class="card-text"><small class="text-muted">Poids : 10
                                    kg<br></small></p>
                            <div style="display:flex; flex-direction: row; ">

                                <input type="button" value="-" class="button-minus border icon-shape icon-sm mx-1 "
                                    data-field="quantity"
                                    style="color:white; border:none; font-weight:bold;background-color: transparent; border-radius:10px; width:130px;">

                                <input type="button" value="+" class="button-plus border icon-shape icon-sm "
                                    style="color:white; border:none; font-weight:bold;background-color: transparent; border-radius:10px; width:130px; margin-left:10px;"
                                    data-field="quantity">
                            </div>


                        </div>

                    </div>
                <?php endfor; ?>

            </div>
        </div>



        <form method='GET'>

            <div id="form-check-section"
                style="display:flex; flex-direction: column; width:450px;padding:16px; border:1px #6c757d solid; row-gap: 5px; height:800px; ">

                <p style="font-size:30px">Sommaire de l'achat</p>
                <div class="row justify-content-between">
                    <div class="col-4" style="width:auto;">
                        One of two columns
                    </div>
                    <div class="col-4" style="width:auto;">
                        One of two columns
                    </div>
                </div>
                <div class="row justify-content-between">
                    <div class="col-4">
                        One of two columns
                    </div>
                    <div class="col-4">
                        One of two columns
                    </div>
                </div>
                <div class="row justify-content-between">
                    <div class="col-4">
                        One of two columns
                    </div>
                    <div class="col-4">
                        One of two columns
                    </div>
                </div>
                <hr />
                <div class="row justify-content-between" style="font-size:30px;">
                    <div class="col-4">
                        Total
                    </div>
                    <div class="col-4">
                        $10000 * 10kg
                    </div>
                </div>
                <input type='submit' value="Checkout" style="width:420px; height:55px; font-size:20px;">
            </div>


        </form>

    </div>
</div>
<?php
require 'views/partials/footer.php';
?>
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
</style>
<div style="display:flex; justify-content: center; flex-direction: column;align-items:center;">

    <div class="card mb-3"
        style="background-color:#1E1E1E !important; padding:10px;border:none;  margin:20px; margin-top:0px; margin-bottom:0px; max-width:50%; max-height:325px; ">
        <div class="row g-0">
            <div class="col-md-4" style="width:50%; max-height:325px; ">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ-YtnuV2n_8xuMZbIQ8voSyC4hjGBN6DLC8w&s"
                    class="img-fluid rounded-start" alt="..." style="width:100%;height:100%;aspect-ratio: auto;">
            </div>
            <div class=" col-md-8" style="padding-left:30px; width:50%; max-height:325px; ">
                <div class="card-body" style="max-height:325px !important;">
                    <h5 class="card-title" style="font-weight:bold;">Sword 1</h5>
                    <p class="card-text" style="font-size:50px; font-weight: bold;"><span
                            style="font-size:30px; ">$</span>777</p>
                    <p class="card-text"><small class="text-muted">Lorem ipsum dolor sit, amet consectetur adipisicing
                            elit. Ea, maxime quos cumque dolorem ad</small></p>
                    <button class="btn btn-outline-secondary " type="button"
                        style="margin-right:10px; width:100%;  border : none; border-radius:8px;padding-top:4px; background-color: #303030;"><a
                            href="/login" class="buttonst " style="color:white;">Acheter</a>
                    </button>
                    <div
                        style="display:flex; flex-direction: column; background-color: #303030; margin-top:10px; padding:15px; border-radius:8px; border:1px  #6c757d solid;">

                        <p style="margin:0px;height:30px;">Moyenne des evaluations <span class="badge bg-secondary"
                                style="width:100px; font-size:15px; height:30px; margin-left:10px; background-color:#434343 !important;">Arme</span>
                        </p>
                        <div class="rating-card">
                            <div class=" star-rating animated-stars"
                                style="display:flex; flex-direction:row; justify-content:flex-start">
                                <!-- la logique est juste mettre les etoiles la -->
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

                </div>
            </div>
        </div>
    </div>
    <!-- <div class="container">
        <h2>Carousel Example</h2>
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
          
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>

          
            <div class="carousel-inner">

                <div class="item active">
                    <img src="1.jpg" alt="Los Angeles" style="width:100%;">
                    <div class="carousel-caption">
                        <h3 class="m1">Los Angeles</h3>
                        <p class="m1">LA is always so much fun!</p>
                    </div>
                </div>

                <div class="item">
                    <img src="2.jpg" alt="Chicago" style="width:100%;">
                    <div class="carousel-caption">
                        <h3 class="m2">Chicago</h3>
                        <p class="m2">Thank you, Chicago!</p>
                    </div>
                </div>

                <div class="item">
                    <img src="3.jpg" alt="New York" style="width:100%;">
                    <div class="carousel-caption">
                        <h3 class="m3">New York</h3>
                        <p class="m3">We love the Big Apple!</p>
                    </div>
                </div>

            </div>

          
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div> -->
</div>

</div>

<?php
require 'views/partials/footer.php';
?>
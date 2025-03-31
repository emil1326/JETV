<style>
    .navtagsw {
        width: 85px;
        height: 32px;
        text-align: center;
        color: white;
    }

    .nav-link:hover {
        color: #303030 !important;
    }

    .navbar-dark .nav-item>.nav-link.active {
        background-color: #444 !important;
        color: white !important;
        border-radius: 8px;
    }

    .navbar-dark .nav-item>.nav-link.active:hover {
        background-color: #444 !important;
        color: #303030 !important;
        border-radius: 8px;
    }

    .nav-link.active {
        background-color: #444 !important;
        color: white !important;
        border-radius: 8px;
    }

    .nav-link.active:hover {
        background-color: #444 !important;
        color: #303030 !important;
        border-radius: 8px;
    }

    .buttonsw {
        width: 83px;
        font-size: 15px;
        height: 32px;
    }

    .buttonst {
        color: white;
        text-decoration: none;
    }

    .nopadding {
        padding-top: 2px;
    }

    @media(min-width:992px) {
        #balance {

            display: none;
        }
    }

    @media (max-width: 992px) {
        .navbar-collapse {
            justify-content: flex-start !important;
            margin-top: 30px;
        }



        #signinregister {
            margin-top: 30px;
            padding-left: 0px !important;
        }
    }
</style>
<div class="container-fluid" style="padding-top:20px;background-color:#1E1E1E; padding-bottom:20px;">
    <nav class="navbar navbar-expand-lg" style="background-color:#1E1E1E !important;">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span> <i class="fa fa-navicon" style="color:#fff; font-size:28px;"></i></span>
            </button>

            <?php if (isAuthenticated()): ?>
                <div style="display:flex; flex-direction:row;align-items:center; padding-right:10px; ">
                    <img src="https://mdbcdn.b-cdn.net/img/new/avatars/2.webp" class="rounded-circle"
                        style="width: 50px; border-radius:10% !important; cursor:pointer;" alt="Avatar" />
                    <p style="margin:0px; margin-left:20px;">
                        <?php
                        $pdo = Database::getInstance()->getPDO();
                        $userModel = new UserModel($pdo);
                        $user = $userModel->selectById($_SESSION['playerID']);
                        echo $user->getUsername();
                        ?>
                    </p>
                    <img style="margin:0px; margin-left:20px;"
                        src="https://images.fallout.wiki/1/1a/Score_currency_caps_l.webp" alt="Card image caps" width="30"
                        height="30">
                    <p style="margin:0px; margin-left:5px;">
                        <?php

                        echo " : " . $user->getCaps() . " Caps";
                        ?>
                    </p>
                    <img style="margin:0px; margin-left:20px;"
                        src="https://cdn.iconscout.com/icon/free/png-256/free-health-symbol-icon-download-in-svg-png-gif-file-formats--medical-sign-services-pack-healthcare-icons-3401408.png?f=webp&w=256"
                        alt="Card image caps" width="30" height="30">
                    <p style="margin:0px; margin-left:5px;">
                        <?php
                        echo " : " . $user->getHealth() . "/100 PV";
                        ?>
                    </p>
                    <img style="margin:0px; margin-left:20px;"
                        src="https://static.wikia.nocookie.net/fallout/images/7/75/FO76_icon_weight.png"
                        alt="Card image caps" width="30" height="30">
                    <p style="margin:0px; margin-left:5px;">
                        <?php
                        $model = new InventoryModel($pdo);

                        echo ' : ' . $model->totalWeight($_SESSION['playerID']) . '/' . $user->getMaxWeight() . " kg";
                        ?>
                    </p>
                    <img style="margin:0px; margin-left:20px;" src="https://static.thenounproject.com/png/4494012-200.png"
                        alt="Card image caps" width="40" height="40">
                    <p style="margin:0px; margin-left:5px;">
                        <?php
                        echo " : " . $user->getDexterity() . " Dex";
                        ?>
                    </p>
                </div>
            <?php endif; ?>

            <div class="collapse navbar-collapse d-md-flex justify-content-md-end" id="navbarNavDropdown">
                <ul class="navbar-nav ">
                    <li class="nav-item nopadding">
                        <a class="nav-link navtagsw nopadding <?php if (isset($accueilActif) && $accueilActif)
                            echo 'active' ?>" aria-current="page" href="/">Accueil</a>
                        </li>
                        <li class="nav-item nopadding">
                            <a class="nav-link navtagsw nopadding <?php if (isset($shopActif) && $shopActif)
                            echo 'active' ?>" href="/shop">Shop</a>
                        </li>
                    <?php if (isAuthenticated()): ?>
                        <li class="nav-item nopadding">
                            <a class="nav-link navtagsw nopadding <?php if (isset($enigmaActif) && $enigmaActif)
                                echo 'active' ?>" href="/enigma">Enigma</a>
                            </li>

                            <li class="nav-item nopadding">
                                <a class="nav-link navtagsw nopadding <?php if (isset($backActif) && $backActif)
                                echo 'active' ?>" href="/backpack">Backpack</a>
                            </li>

                            <li class="nav-item nopadding">
                                <a class="nav-link navtagsw nopadding <?php if (isset($cartActif) && $cartActif)
                                echo 'active' ?>" href="/cart">Cart</a>
                            </li>
                    <?php endif; ?>

                    <form class="container-fluid justify-content-start" id="signinregister">
                        <?php if (!isAuthenticated()) {
                            echo '<button class="btn btn-outline-secondary buttonsw" type="button"
                            style="margin-right:10px;  border-radius: 8px;padding-top:4px; background-color: #303030;"><a
                                href="/login" class="buttonst buttonsw" style="color:white;">Sign
                                in</a>
                        </button>';
                            echo '<button class="btn  btn-outline-secondary buttonsw" type="button"
                            style="background-color:white; border-radius: 8px;padding-top:4px;"><a href="/signup"
                                class="buttonst buttonsw" style="color:black;">Register</a></button>';
                        } else {
                            echo '<button class="btn btn-outline-secondary buttonsw" type="button"
                            style="margin-right:10px;  border-radius: 8px;padding-top:4px; background-color: #303030;"><a
                                href="/logout" class="buttonst buttonsw" style="color:white;">Logout</a>
                        </button>';
                        }
                        ?>
                    </form>
                </ul>
            </div>
        </div>
    </nav>
</div>
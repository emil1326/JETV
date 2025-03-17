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
            <div
                style="display:flex; flex-direction:row;align-items:center; width:160px; padding-right:10px; cursor:pointer;">
                <img src="https://mdbcdn.b-cdn.net/img/new/avatars/2.webp" class="rounded-circle"
                    style="width: 50px; border-radius:10% !important;" alt="Avatar" />
                <p style="margin:0px; margin-left:20px;"> Thomas</p>
            </div>


            <div class="collapse navbar-collapse d-md-flex justify-content-md-end" id="navbarNavDropdown">
                <ul class="navbar-nav ">
                    <div id="balance">

                        <p>5000</p>
                        <p>123/1000</p>
                    </div>
                    <li class="nav-item nopadding">
                        <a class="nav-link navtagsw nopadding active" aria-current="page" href="/">Accueil</a>
                    </li>
                    <li class="nav-item nopadding">
                        <a class="nav-link navtagsw nopadding" href="/shop">Shop</a>
                    </li>
                    <li class="nav-item nopadding">
                        <a class="nav-link navtagsw nopadding" href="/enigma">Enigma</a>
                    </li>

                    <li class="nav-item nopadding">
                        <a class="nav-link navtagsw nopadding" href="/backpack">Backpack</a>
                    </li>

                    <li class="nav-item nopadding">
                        <a class="nav-link navtagsw nopadding" href="/cart">Cart</a>
                    </li>

                    <form class="container-fluid justify-content-start" id="signinregister">
                        <button class="btn btn-outline-secondary buttonsw" type="button"
                            style="margin-right:10px;  border-radius: 8px;padding-top:4px; background-color: #303030;"><a
                                href="/login" class="buttonst buttonsw" style="color:white;">Sign
                                in</a>
                        </button>
                        <button class="btn  btn-outline-secondary buttonsw" type="button"
                            style="background-color:white; border-radius: 8px;padding-top:4px;"><a href="/signup"
                                class="buttonst buttonsw" style="color:black;">Register</a></button>
                    </form>
                </ul>
            </div>
        </div>
    </nav>
</div>

<script>


</script>
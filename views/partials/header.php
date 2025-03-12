<style>
    .navtagsw {
        width: 90px;
        height: 32px;
        text-align: center;
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
</style>

<div class="container-fluid" style="padding-top:10px;">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse d-md-flex justify-content-md-end" id="navbarNavDropdown">
                <ul class="navbar-nav ">

                    <li class="nav-item">
                        <a class="nav-link navtagsw active" aria-current="page" href="/">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link navtagsw" href="/shop">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link navtagsw" href="/enigma">Enigma</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link navtagsw" href="/backpack">Backpack</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link navtagsw" href="/cart">Cart</a>
                    </li>

                    <form class="container-fluid justify-content-start">
                        <button class="btn btn-outline-secondary buttonsw" type="button"
                            style="margin-right:10px;  border-radius: 8px;"><a href="/connexion"
                                class="buttonst buttonsw" style="color:white;">Sign
                                in</a>
                        </button>
                        <button class="btn  btn-outline-secondary buttonsw" type="button"
                            style="background-color:white; border-radius: 8px;"><a href="/register"
                                class="buttonst buttonsw" style="color:black;">Register</a></button>
                    </form>
                </ul>
            </div>
        </div>
    </nav>


    <script>

        function clickedIt() {
            alert("hi");
        }
    </script>
<?php
require 'partials/head.php';
?>
<div class="container marketing">

    <!-- Articles -->
    <div class="px-4 py-5 my-5 ">

        <h1 class="display-5 fw-bold text-body-emphasis text-center">Connexion</h1>

        <div class="col-lg-6 mx-auto ">

            <form method="post">

                <?= $messageKey ?? '' ?>

                <div class="mb-3">
                    <label for="text" class="form-label">Alias</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?= $username ?? '' ?>">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mot de Passe</label>
                    <input type="password" class="form-control" id="password" name="password" value="<?= $password ?? '' ?>">
                </div>

                <button type="submit" class="btn btn-primary">Authentifier</button>
                <a class="btn btn-secondary" role="button" href="/">Annuler</a>
            </form>

        </div>
    </div>



</div>
<?php

require 'partials/footer.php';

?>

<?php
require 'partials/head.php';
require 'partials/header.php';

$messageKey = $messageKey ?? '';

if (!isset($messageKey) || $messageKey != null)
    $messageKey = '';

?>
<div class="container marketing">

    <!-- Articles -->
    <div class="px-4 py-5 my-5 ">

        <h1 class="display-5 fw-bold text-body-emphasis text-center">Création de compte</h1>

        <div class="col-lg-6 mx-auto ">

            <form method="post">

                <?php if ($messageKey != ''): ?>
                    <div class="alert alert-danger">
                        <?= $messageKey ?>
                    </div>
                <?php endif; ?>

                <div class="mb-3">
                    <label for="firstName" class="form-label">Prénom</label>
                    <input type="text" class="form-control" id="firstName" name="firstName" value="<?= $firstName ?? '' ?>">
                </div>

                <div class="mb-3">
                    <label for="lastName" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="lastName" name="lastName" value="<?= $lastName ?? '' ?>">
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">Alias</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?= $username ?? '' ?>">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mot de Passe</label>
                    <input type="password" class="form-control" id="password" name="password" value="<?= $pass ?? '' ?>">
                </div>

                <div class="mb-3">
                    <label for="passwordConfirm" class="form-label">Confirmez le Mot de passe</label>
                    <input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm" value="<?= $pass2 ?? '' ?>">
                </div>

                <button type="submit" class="btn btn-primary">Créer</button>
                <a class="btn btn-secondary" role="button" href="/">Annuler</a>
            </form>

        </div>

    </div>

</div>
<?php

require 'partials/footer.php';

?>
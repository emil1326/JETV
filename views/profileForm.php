<?php
require 'partials/head.php';
?>
<style>
    
fieldset {
    width: 100%;
    border: 1px solid #ccc;
    border-radius: 6px;
    text-align: left;
}
legend {
    transform: translate(0, -27px);
    font-size: 17px;
    font-weight: 500;
    margin-bottom: -27px !important;
    width: auto;
    padding: 2px;
}
</style>
<div class="container marketing">

    <!-- Articles -->
    <div class="px-4 py-5 my-5 ">

        <h1 class="display-5 fw-bold text-body-emphasis text-center">Modification de profile</h1>

        <div class="col-lg-6 mx-auto ">

            <form method="post">

                <p><?= $messageKey ?? '' ?></p>

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
                </br>
                <fieldset class="mb-3">
                    <legend class="col-form-label pt-0">Modifier mot de passe : </legend>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de Passe</label>
                        <input type="password" class="form-control" id="password" name="password" value="<?= $pass ?? '' ?>">
                    </div>

                    <div class="mb-3">
                        <label for="passwordConfirm" class="form-label">Confirmez le Mot de passe</label>
                        <input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm" value="<?= $pass2 ?? '' ?>">
                    </div>
                </fieldset>
                <button type="submit" class="btn btn-primary">Modifier</button>
                <a class="btn btn-secondary" role="button" href="/">Annuler</a>
            </form>
            <form action="upload.php" method="post" enctype="multipart/form-data">
            Select image to upload:
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Upload Image" name="submit">
            </form>
        </div>

    </div>

</div>

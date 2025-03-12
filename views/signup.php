<?php
  require 'partials/head.php';
  require 'partials/header.php';
?>
<div class="container marketing">

    <!-- Articles -->
    <div class="px-4 py-5 my-5 ">

      <h1 class="display-5 fw-bold text-body-emphasis text-center">Création de compte</h1>

      <div class="col-lg-6 mx-auto ">
        
      <form method="post">
            
            <?= $messageKey ?? ''?>
                            
            <div class="mb-3">
                <label for="name" class="form-label">Nom</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $name ?? '' ?>">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Courriel</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $email ?? ''?>">
            </div>

            <div class="mb-3">
                <label for="pass" class="form-label">Mot de Passe</label>
                <input type="password" class="form-control" id="pass" name="pass" value="<?= $pass ?? ''?>">
            </div>

            <div class="mb-3">
                <label for="pass2" class="form-label">Répétez le Mot de passe</label>
                <input type="password" class="form-control" id="pass2" name="pass2" value="<?= $pass2 ?? ''?>">
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
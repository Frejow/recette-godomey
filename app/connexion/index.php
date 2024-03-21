<?php

if (est_connecter()) {
    $message = "Vous êtes déja connecté. Veuillez poursuivre votre navigation.";
    header('location:index.php?page=accueil&message=' . $message);
}

$erreurs = [];
$donnees = [];
$erreur = '';
$success = '';

if (isset($_GET['erreurs']) && !empty($_GET['erreurs'])) {
    $erreurs = json_decode($_GET['erreurs'], true);
}

if (isset($_GET['donnees']) && !empty($_GET['donnees'])) {
    $donnees = json_decode($_GET['donnees'], true);
}

if (isset($_GET['erreur']) && !empty($_GET['erreur'])) {
    $erreur = $_GET['erreur'];
}

if (isset($_GET['success']) && !empty($_GET['success'])) {
    $success = $_GET['success'];
}

?>

<div class="row g-3 d-flex justify-content-center">
    <form class="col-md-6" action="index.php?page=traitement-connexion" method="POST">
        <h3 class="text-center">
            Se connecter
        </h3>
        <p class="text-center">
            Veuillez fournir vos informations afin de vous connectez au site des recettes.
        </p>

        <?php
        if (!empty($erreur)) {
        ?>
            <div class="alert alert-danger" role="alert">
                <?= $erreur; ?>
            </div>
        <?php
        }


        if (!empty($success)) {
        ?>
            <div class="alert alert-success" role="alert">
                <?= $success; ?>
            </div>
        <?php
        }
        ?>

        <div class="mb-3">
            <label for="connexion-email" class="form-label">
                Adresse email :
                <span class="text-danger">(*)</span>
            </label>
            <input type="email" name="email" class="form-control connexion-email" id="connexion-email" placeholder="Veuillez entrer votre adresse email." required value="<?= (isset($donnees['email']) && !empty($donnees['email'])) ? $donnees['email'] : '' ?>">
            <p class="text-danger">
                <?= (isset($erreurs['email']) && !empty($erreurs['email'])) ? $erreurs['email'] : '' ?>
            </p>
        </div>

        <div class="mb-3">
            <label for="connexion-mot-de-passe" class="form-label">
                Mot de passe :
                <span class="text-danger">(*)</span>
            </label>
            <input type="password" name="mot-de-passe" class="form-control connexion-mot-de-passe" id="connexion-mot-de-passe" placeholder="Veuillez entrer votre mot de passe." required value="<?= (isset($donnees['mot-de-passe']) && !empty($donnees['mot-de-passe'])) ? $donnees['mot-de-passe'] : '' ?>">
            <p class="text-danger">
                <?= (isset($erreurs['mot-de-passe']) && !empty($erreurs['mot-de-passe'])) ? $erreurs['mot-de-passe'] : '' ?>
            </p>
        </div>

        <div class="d-flex justify-content-between">
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="connexion-se-souvenir-de-moi">
                <label class="form-check-label" for="connexion-se-souvenir-de-moi">
                    Se souvenir de moi
                </label>
            </div>
            <div class="mb-3 form-check">
                <a href="index.php?page=mot-de-passe-oublie" class="text-right">
                    Mot de passe oublié
                </a>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>

    <a href="index.php?page=inscription" class="text-center">Je souhaite m'inscrire</a>
</div>
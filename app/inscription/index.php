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
    <form class="col-md-6" action="index.php?page=traitement-inscription" method="POST" novalidate>
        <h3 class="text-center">
            S'inscrire
        </h3>

        <p class="text-center">
            Veuillez fournir vos informations afin de creer un compte sur le site des recettes.
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
            <label for="inscription-nom" class="form-label">
                Nom :
                <span class="text-danger">(*)</span>
            </label>
            <input type="text" name="nom" class="form-control inscription-nom" id="inscription-nom" placeholder="Veuillez entrer votre nom de famille" required value="<?= (isset($donnees['nom']) && !empty($donnees['nom'])) ? $donnees['nom'] : '' ?>">
            <p class="text-danger">
                <?= (isset($erreurs['nom']) && !empty($erreurs['nom'])) ? $erreurs['nom'] : '' ?>
            </p>
        </div>

        <div class="mb-3">
            <label for="inscription-prenoms" class="form-label">
                Prénoms :
                <span class="text-danger">(*)</span>
            </label>
            <input type="text" name="prenoms" class="form-control inscription-prenoms" id="inscription-prenoms" placeholder="Veuillez entrer vos prénoms" required value="<?= (isset($donnees['prenoms']) && !empty($donnees['prenoms'])) ? $donnees['prenoms'] : '' ?>">
            <p class="text-danger">
                <?= (isset($erreurs['prenoms']) && !empty($erreurs['prenoms'])) ? $erreurs['prenoms'] : '' ?>
            </p>
        </div>

        <div class="mb-3">
            <label for="inscription-sexe" class="form-label">
                Sexe :
                <span class="text-danger">(*)</span>
            </label>
            <select name="sexe" class="form-select inscription-sexe" id="inscription-sexe">
                <option <?= (!isset($donnees['sexe']) || !empty($donnees['sexe'])) ? 'selected' : '' ?>>Selectionner votre sexe</option>
                <option value="M" <?= (isset($donnees['sexe']) && !empty($donnees['sexe']) && $donnees['sexe'] === "M") ? 'selected' : '' ?>>Homme</option>
                <option value="F" <?= (isset($donnees['sexe']) && !empty($donnees['sexe']) && $donnees['sexe'] === "F") ? 'selected' : '' ?>>Femme</option>
                <option value="A" <?= (isset($donnees['sexe']) && !empty($donnees['sexe']) && $donnees['sexe'] === "A") ? 'selected' : '' ?>>Autre</option>
            </select>
            <p class="text-danger">
                <?= (isset($erreurs['sexe']) && !empty($erreurs['sexe'])) ? $erreurs['sexe'] : '' ?>
            </p>
        </div>

        <div class="mb-3">
            <label for="inscription-email" class="form-label">
                Adresse email :
                <span class="text-danger">(*)</span>
            </label>
            <input type="email" name="email" class="form-control inscription-email" id="inscription-email" placeholder="Veuillez entrer votre adresse email." required value="<?= (isset($donnees['email']) && !empty($donnees['email'])) ? $donnees['email'] : '' ?>">
            <p class="text-danger">
                <?= (isset($erreurs['email']) && !empty($erreurs['email'])) ? $erreurs['email'] : '' ?>
            </p>
        </div>

        <div class="mb-3">
            <label for="inscription-mot-de-passe" class="form-label">
                Mot de passe :
                <span class="text-danger">(*)</span>
            </label>
            <input type="password" name="mot-de-passe" class="form-control inscription-mot-de-passe" id="inscription-mot-de-passe" placeholder="Veuillez entrer votre mot de passe." required value="<?= (isset($donnees['mot-de-passe']) && !empty($donnees['mot-de-passe'])) ? $donnees['mot-de-passe'] : '' ?>">
            <p class="text-danger">
                <?= (isset($erreurs['mot-de-passe']) && !empty($erreurs['mot-de-passe'])) ? $erreurs['mot-de-passe'] : '' ?>
            </p>
        </div>

        <div class="mb-3">
            <label for="inscription-confirmer-mot-de-passe" class="form-label">
                Confirmer le mot de passe :
                <span class="text-danger">(*)</span>
            </label>
            <input type="password" name="confirmer-mot-de-passe" class="form-control inscription-confirmer-mot-de-passe" id="inscription-confirmer-mot-de-passe" placeholder="Veuillez entrer la confirmation de votre mot de passe." required value="<?= (isset($donnees['confirmer-mot-de-passe']) && !empty($donnees['confirmer-mot-de-passe'])) ? $donnees['confirmer-mot-de-passe'] : '' ?>">
            <p class="text-danger">
                <?= (isset($erreurs['confirmer-mot-de-passe']) && !empty($erreurs['confirmer-mot-de-passe'])) ? $erreurs['confirmer-mot-de-passe'] : '' ?>
            </p>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="terms-conditions" class="form-check-input inscription-terms-conditions" id="inscription-terms-conditions" <?= (isset($donnees['terms-conditions']) && !empty($donnees['terms-conditions'])) ? 'checked' : '' ?>>
            <label class="form-check-label" for="inscription-terms-conditions">
                J'accepte les terms et conditions du site des recettes
                <span class="text-danger">(*)</span>
            </label>
            <p class="text-danger">
                <?= (isset($erreurs['terms-conditions']) && !empty($erreurs['terms-conditions'])) ? $erreurs['terms-conditions'] : '' ?>
            </p>
        </div>

        <button type="submit" class="btn btn-primary">S'inscrire</button>
    </form>

    <a href="index.php?page=connexion" class="text-center">Je souhaite me contecter</a>
</div>
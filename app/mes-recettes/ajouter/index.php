<?php

if (!est_connecter()) {
    $message = "Vous n'êtes pas connecté.";
    header('location:index.php?page=connexion&erreur=' . $message);
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

<div class="row d-flex align-items-center">
    <div class="col-md-6">
        <h3>
            Ajout d'une recette
        </h3>
    </div>

    <div class="col-md-6 d-flex justify-content-end">
        <a href="index.php?page=mes-recettes" class="btn btn-primary">
            Liste des recettes
        </a>
    </div>
</div>

<div class="row g-3 d-flex justify-content-center">
    <form class="col-md-6" action="index.php?page=traitement-ajouter-recette" method="POST" novalidate enctype="multipart/form-data">
        <p class="text-center">
            Veuillez fournir les informations relatives a la nouvelle recette.
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
            <label for="ajout-recette-nom" class="form-label">
                Nom :
                <span class="text-danger">(*)</span>
            </label>
            <input type="text" name="nom" class="form-control ajout-recette-nom" id="ajout-recette-nom" placeholder="Veuillez entrer le nom de la recette" required value="<?= (isset($donnees['nom']) && !empty($donnees['nom'])) ? $donnees['nom'] : '' ?>">
            <p class="text-danger">
                <?= (isset($erreurs['nom']) && !empty($erreurs['nom'])) ? $erreurs['nom'] : '' ?>
            </p>
        </div>

        <div class="mb-3">
            <label for="ajout-recette-description" class="form-label">
                Description :
                <span class="text-danger">(*)</span>
            </label>
            <input type="text" name="description" class="form-control ajout-recette-description" id="ajout-recette-description" placeholder="Veuillez entrer la description de la recette" required value="<?= (isset($donnees['description']) && !empty($donnees['description'])) ? $donnees['description'] : '' ?>">
            <p class="text-danger">
                <?= (isset($erreurs['description']) && !empty($erreurs['description'])) ? $erreurs['description'] : '' ?>
            </p>
        </div>

        <div class="mb-3">
            <label for="ajout-recette-recette" class="form-label">
                Recette :
                <span class="text-danger">(*)</span>
            </label>
            <textarea name="recette" class="form-control ajout-recette-recette" id="ajout-recette-recette" rows="5"><?= (isset($donnees['recette']) && !empty($donnees['recette'])) ? $donnees['recette'] : '' ?></textarea>
            <p class="text-danger">
                <?= (isset($erreurs['recette']) && !empty($erreurs['recette'])) ? $erreurs['recette'] : '' ?>
            </p>
        </div>

        <div class="mb-3">
            <label for="ajout-recette-image" class="form-label">
                Image :
                <span class="text-danger">(*)</span>
            </label>
            <input class="form-control ajout-recette-image" name="image" type="file" id="ajout-recette-image">
            <p class="text-danger">
                <?= (isset($erreurs['image']) && !empty($erreurs['image'])) ? $erreurs['image'] : '' ?>
            </p>
        </div>

        <button type="submit" class="btn btn-primary mb-3">Ajouter</button>
    </form>
</div>
<?php

if (empty($_GET['id'])) {
    $message = "La recette que vous souhaitez consulter n'existe pas.";
    header('location:index.php?page=accueil&erreur=' . $message);
}

$recette = recette($_GET['id']);

if (empty($recette)) {
    $message = "La recette que vous souhaitez consulter n'existe pas.";
    header('location:index.php?page=accueil&erreur=' . $message);
}
?>

<div class="row">

    <div class="col md-6">
        <img style="" src="/app/uploads/<?= $recette['image']; ?>" class="card-img-top" alt="Image de la recette">
    </div>

    <div class="col md-6">
        <h1 class="h1">
            <?= $recette['nom']; ?>
        </h1>
        <hr>
        <p>
            <?= $recette['description']; ?>
        </p>
        <hr>
        <p class="fw-bold">
            Les étapes de la préparation de la recette :
        </p>
        <p>
            <?= $recette['recette']; ?>
        </p>
    </div>

</div>

<hr>

<div class="row mt-4">
    <div class="col md-6">
        <h2 class="h2">
            Commentaires
        </h1>
        <p>
            Aucun commentaires n'ai disponible pour le moment.
        </p>
    </div>


    <div class="col md-6">
        <h2 class="h2">
            Laisser un nouveau commentaire
        </h1>
        <form action="index.php?page=ajouter-commentaire&id=<?= $_GET['id']; ?>" method="POST" novalidate enctype="multipart/form-data">

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
                <label for="ajout-commentaire-nom-prenoms" class="form-label">
                    Nom & prénoms:
                    <span class="text-danger">(*)</span>
                </label>
                <input type="text" name="nom-prenoms" class="form-control ajout-commentaire-nom-prenoms" id="ajout-commentaire-nom-prenoms" placeholder="Veuillez entrer votre nom et prénoms" required value="<?= (isset($donnees['nom-prenoms']) && !empty($donnees['nom-prenoms'])) ? $donnees['nom-prenoms'] : '' ?>">
                <p class="text-danger">
                    <?= (isset($erreurs['nom-prenoms']) && !empty($erreurs['nom-prenoms'])) ? $erreurs['nom-prenoms'] : '' ?>
                </p>
            </div>

            <div class="mb-3">
                <label for="ajout-commentaire-commentaire" class="form-label">
                    Commentaire :
                    <span class="text-danger">(*)</span>
                </label>
                <textarea name="commentaire" class="form-control ajout-commentaire-commentaire" id="ajout-commentaire-commentaire" rows="5"><?= (isset($donnees['commentaire']) && !empty($donnees['commentaire'])) ? $donnees['commentaire'] : '' ?></textarea>
                <p class="text-danger">
                    <?= (isset($erreurs['commentaire']) && !empty($erreurs['commentaire'])) ? $erreurs['commentaire'] : '' ?>
                </p>
            </div>

            <button type="submit" class="btn btn-primary mb-3">Commenter</button>
        </form>
    </div>
</div>
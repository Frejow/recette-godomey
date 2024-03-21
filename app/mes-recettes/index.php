<?php

if (!est_connecter()) {
    $message = "Vous n'êtes pas connecté.";
    header('location:index.php?page=connexion&erreur=' . $message);
}


if (!empty($_GET['message'])) {
?>
    <div class="alert alert-info" role="alert">
        <?= $_GET['message']; ?>
    </div>
<?php

}


if (!empty($_GET['success'])) {
?>
    <div class="alert alert-success" role="alert">
        <?= $_GET['success']; ?>
    </div>
<?php

}

if (!empty($_GET['erreur'])) {
?>
    <div class="alert alert-danger" role="alert">
        <?= $_GET['erreur']; ?>
    </div>
<?php
}

$recettes = recettes($_SESSION['utilisateur_connecter']['id']);

// die(var_dump($recettes));

?>

<div class="row d-flex align-items-center">
    <div class="col-md-6">
        <h3>
            Mes recettes
        </h3>
    </div>

    <div class="col-md-6 d-flex justify-content-end">
        <a href="index.php?page=ajouter-recette" class="btn btn-primary">
            Ajouter une recette
        </a>
    </div>
</div>

<div class="row d-flex align-items-center">
    <div class="col-md-12">
        <?php

        if (empty($recettes)) { ?>
            <p>
                Aucune recette n'est disponible pour le moment.
            </p>
        <?php } else { ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Description</th>
                        <th scope="col">Recette</th>
                        <th scope="col">action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recettes as $recette) { ?>
                        <tr>
                            <th scope="row">
                                <?= $recette['id']; ?>
                            </th>
                            <td>
                                <p>
                                    <span>
                                        <?= $recette['nom']; ?>
                                    </span>
                                    <br>
                                    <?php if (empty($recette['activer-le'])) { ?>
                                        <span class="badge bg-danger">
                                            Pas actif
                                        </span>
                                    <?php } else { ?>
                                        <span class="badge bg-success">
                                            Est actif
                                        </span>
                                    <?php } ?>
                                </p>
                            </td>
                            <td>
                                <?= $recette['description']; ?>
                            </td>
                            <td>
                                <?= $recette['recette']; ?>
                            </td>
                            <td>
                                <a href="#" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#details-recette-<?= $recette['id']; ?>">
                                    Détails
                                </a>

                                <a href="index.php?page=modifier-recette&id=<?= $recette['id']; ?>" class="btn btn-warning">
                                    Modifier
                                </a>

                                <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#supprimer-recette-<?= $recette['id']; ?>">
                                    Supprimer
                                </a>
                            </td>
                        </tr>

                        <!-- Modal : details recette -->
                        <div class="modal fade" id="details-recette-<?= $recette['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">
                                            Détails sur la recette "<?= $recette['nom']; ?>"
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>
                                            <span class="fw-bold">Image</span> :
                                        </p>
                                        <p class="text-center">
                                            <img style="height: 200px;width: 100%;object-fit: cover;" src="/app/uploads/<?= $recette['image']; ?>" class="card-img-top" alt="Image de la recette">
                                        </p>
                                        <p>
                                            <span class="fw-bold">Nom</span> : <?= $recette['nom']; ?>
                                        </p>
                                        <p>
                                            <span class="fw-bold">Description</span> : <?= $recette['description']; ?>
                                        </p>
                                        <p>
                                            <span class="fw-bold">Étapes de la recette</span> : <?= $recette['recette']; ?>
                                        </p>
                                        <p>
                                            <span class="fw-bold">Activer le </span> : <?= $recette['activer-le']; ?>
                                        </p>
                                        <p>
                                            <span class="fw-bold">Date de dernière mise a jour</span> : <?= $recette['mit-a-jour-le']; ?>
                                        </p>
                                        <p>
                                            <span class="fw-bold">Créer le</span> : <?= $recette['creer-le']; ?>
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal : details recette -->
                        <div class="modal fade" id="supprimer-recette-<?= $recette['id']; ?>" tabindex="-1" aria-labelledby="effacer" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="effacer">
                                            Suppression de la recette "<?= $recette['nom']; ?>"
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>
                                            Etes vous sur de vouloir supprimer cette recette ?
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="index.php?page=supprimer-recette&id=<?= $recette['id']; ?>" method="post">
                                            <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Oui</button>
                                        </form>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
</div>
<?php
if (!empty($_GET['message'])) {
?>
    <div class="alert alert-info" role="alert">
        <?= $_GET['message']; ?>
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
$nombre_de_recette_total = nombre_de_recette_dans_la_base_de_donnees();

$nombre_de_recette_par_page = (isset($_GET['nombre_de_recette_par_page']) && !empty($_GET['nombre_de_recette_par_page'])) ? $_GET['nombre_de_recette_par_page'] : 12;
$numero_de_page =  (isset($_GET['numero_de_page']) && !empty($_GET['numero_de_page'])) ? $_GET['numero_de_page'] : 1;

$numero_de_page_total = round($nombre_de_recette_total / $nombre_de_recette_par_page, 0);

$recettes = recettes(null, $nombre_de_recette_par_page, $numero_de_page);
?>

<h3 class="position-relative">
    Liste des recettes
    <span class="badge bg-success">
        <?= $nombre_de_recette_total . " recettes au total"; ?>
    </span>
</h3>
</div>

<div class="row g-4">
    <?php if (empty($recettes)) { ?>
        <p>
            Aucune recette n'est disponible pour le moment.
        </p>
        <?php } else {
        foreach ($recettes as $recette) { ?>
            <div class="col-md-3">
                <div class="card">
                    <img style="height: 200px;width: 100%;object-fit: cover;" src="/app/uploads/<?= $recette['image']; ?>" class="card-img-top" alt="Image de la recette">
                    <div class="card-body">
                        <h5 class="card-title">
                            <?= $recette['nom']; ?>
                        </h5>
                        <a href="index.php?page=details-recette&id=<?= $recette['id']; ?>" class="btn btn-primary">Voir les détails</a>
                    </div>
                </div>
            </div>
    <?php
        }
    }
    ?>
</div>

<div class="mt-3 d-flex justify-content-end">
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <?php if ($numero_de_page > 1) { ?>
                <li class="page-item">
                    <a class="page-link" href="index.php?numero_de_page=<?= $numero_de_page - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php } ?>
            <li class="page-item">
                <a class="page-link" href="index.php?numero_de_page=<?= $numero_de_page; ?>">
                    <?= $numero_de_page; ?>
                </a>
            </li>
            <?php if ($numero_de_page < $numero_de_page_total) { ?>
                <li class="page-item">
                    <a class="page-link" href="index.php?numero_de_page=<?= $numero_de_page + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </nav>
</div>
<?php
session_start();

require_once(__DIR__ . '/app/fonction.php');
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de recettes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
    <div class="container">
        <!-- inclusion de l'entête du site -->
        <?php require_once(__DIR__ . '/app/commun/header.php'); ?>

        <div class="row g-3 mt-3">
            <?php
            if (isset($_GET['page']) && !empty($_GET['page'])) {
                switch ($_GET['page']) {
                    case 'accueil':
                        include_once(__DIR__ . '/app/accueil.php');
                        break;

                    case 'details-recette':
                        include_once(__DIR__ . '/app/details-recette.php');
                        break;

                    case 'contact':
                        include_once(__DIR__ . '/app/contact.php');
                        break;

                    case 'connexion':
                        include_once(__DIR__ . '/app/connexion/index.php');
                        break;

                    case 'traitement-connexion':
                        include_once(__DIR__ . '/app/connexion/traitement.php');
                        break;

                    case 'inscription':
                        include_once(__DIR__ . '/app/inscription/index.php');
                        break;

                    case 'traitement-inscription':
                        include_once(__DIR__ . '/app/inscription/traitement.php');
                        break;

                    case 'mot-de-passe-oublie':
                        include_once(__DIR__ . '/app/mot-de-passe-oublie/index.php');
                        break;

                    case 'traitement-mot-de-passe-oublie':
                        include_once(__DIR__ . '/app/mot-de-passe-oublie/traitement.php');
                        break;

                    case 'mes-recettes':
                        include_once(__DIR__ . '/app/mes-recettes/index.php');
                        break;

                    case 'ajouter-recette':
                        include_once(__DIR__ . '/app/mes-recettes/ajouter/index.php');
                        break;

                    case 'traitement-ajouter-recette':
                        include_once(__DIR__ . '/app/mes-recettes/ajouter/traitement.php');
                        break;

                    case 'modifier-recette':
                        include_once(__DIR__ . '/app/mes-recettes/modifier/index.php');
                        break;

                    case 'traitement-modifier-recette':
                        include_once(__DIR__ . '/app/mes-recettes/modifier/traitement.php');
                        break;

                    case 'supprimer-recette':
                        include_once(__DIR__ . '/app/mes-recettes/supprimer.php');
                        break;

                    case 'mon-profil':
                        include_once(__DIR__ . '/app/mon-profil/index.php');
                        break;

                    case 'mise-a-jour-informations-personnelles-traitement':
                        include_once(__DIR__ . '/app/mon-profil/mise-a-jour-informations-personnelles-traitement.php');
                        break;

                    case 'mise-a-jour-mot-de-passe-traitement':
                        include_once(__DIR__ . '/app/mon-profil/mise-a-jour-mot-de-passe-traitement.php');
                        break;

                    case 'deconnexion':
                        include_once(__DIR__ . '/app/deconnexion.php');
                        break;

                    default:
                        include_once(__DIR__ . '/app/404.php');
                        break;
                }
            } else {
                include_once(__DIR__ . '/app/accueil.php');
            }
            ?>
        </div>
    </div>
    <!-- inclusion du bas de page du site -->
    <?php require_once(__DIR__ . '/app/commun/footer.php'); ?>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</html>
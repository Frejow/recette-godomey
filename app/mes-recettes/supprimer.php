<?php

if (!est_connecter()) {
    $message = "Vous n'êtes pas connecté.";
    header('location:index.php?page=connexion&erreur=' . $message);
}

if (empty($_GET['id'])) {
    $message = "La recette que vous souhaitez supprimée n'existe pas.";
    header('location:index.php?page=mes-recettes&erreur=' . $message);
}

$recette = recette($_GET['id']);

if (empty($recette)) {
    $message = "La recette que vous souhaitez supprimée n'existe pas.";
    header('location:index.php?page=mes-recettes&erreur=' . $message);
} else if ($recette['id_utilisateur'] != $_SESSION['utilisateur_connecter']['id']) {
    $message = "La recette que vous souhaitez supprimée ne vous appartient pas.";
    header('location:index.php?page=mes-recettes&erreur=' . $message);
}

$supprimer_recette = supprimer_recette($_GET['id']);

$success = "";
$erreur = "";
if ($supprimer_recette) {
    $success = "Recette supprimer avec succès.";
} else {
    $erreur = "Oups!!! une erreur inatendue s'est produite lors de la suppression de la recette.";
}

header('location: index.php?page=mes-recettes&erreur=' . $erreur . '&success=' . $success);

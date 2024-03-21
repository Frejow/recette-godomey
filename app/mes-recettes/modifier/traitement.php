<?php
$erreurs = [];
$donnees = [];
$success = '';
$erreur = '';

connexion_db();

foreach ($_POST as $cle => $valeur) {
    $donnees[$cle] = strip_tags($valeur);
}

if (empty($_POST['nom'])) {
    $erreurs['nom'] = 'Le champ nom est obligatoire.';
}

if (empty($_POST['description'])) {
    $erreurs['description'] = 'Le champ description est obligatoire.';
}

if (empty($_POST['recette'])) {
    $erreurs['recette'] = 'Le champ recette est obligatoire.';
}

if (!isset($_FILES['image']) || $_FILES['image']['error'] != 0) {
    $erreurs['image'] = 'Le champ image est obligatoire.';
} else {
    $enregistrer_une_image = enregistrer_une_image('image');
    if (is_string($enregistrer_une_image)) {
        $erreurs['image'] = $enregistrer_une_image;
    } elseif (!$enregistrer_une_image) {
        $erreurs['image'] = "Oups!!! une erreur s'est produite lors de l'enregistrement de l'image.";
    } elseif ($enregistrer_une_image) {
        $donnees['image'] = basename($_FILES['image']['name']);
    }
}

if (empty($_POST) || !empty($erreurs)) {
    $erreur = "Oups!!! Un ou plusieur champs sont vide(s) ou mal(s) renseigné(s).";
} else {
    //$donnees['id_utilisateur'] = $_SESSION['utilisateur_connecter']['id'];
    $donnees['id_recette'] = $_GET['id'];
    $modifier_recette = modifier_recette($donnees);
    if ($modifier_recette) {
        $success = "Modification de recette effectuée avec succès.";
    } else {
        $erreur = "Oups!!! Une erreur est survenue lors de la modification de la recette.Veuille réessayer.";
    }
}

if (empty($erreur)) {
    header('location: index.php?page=mes-recettes&erreur=' . $erreur . '&erreurs=' . json_encode($erreurs)   . '&donnees=' . json_encode($donnees) . '&success=' . $success);
} else {
    header('location: index.php?page=modifier-recette&id=' . $_GET['id'] . '&erreur=' . $erreur . '&erreurs=' . json_encode($erreurs)   . '&donnees=' . json_encode($donnees) . '&success=' . $success);
}



<?php
$erreurs = [];
$donnees = [];
$success = '';
$erreur = '';

connexion_db();

foreach ($_POST as $cle => $valeur) {
    $donnees[$cle] = strip_tags($valeur);
}

if (empty($_POST['email'])) {
    $erreurs['email'] = 'Le champ adresse email est obligatoire.';
} elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $erreurs['email'] = 'Le champ adresse email doit etre une adresse mail valide.';
}

if (empty($_POST['mot-de-passe'])) {
    $erreurs['mot-de-passe'] = 'Le champ mot de passe est obligatoire.';
} elseif (strlen($_POST['mot-de-passe']) < 8) {
    $erreurs['mot-de-passe'] = 'Le champ mot de passe doit avoir une taille minimum de huit caractères.';
}

if (empty($_POST) || !empty($erreurs)) {
    $erreur = "Oups!!! Un ou plusieur champs sont vide(s) ou mal(s) renseigné(s).";
} else {
    $utilisateur = $donnees;
    $utilisateur['mot_de_passe'] = sha1($utilisateur['mot-de-passe']);
    unset($utilisateur['mot-de-passe']);
    $utilisateur_connecter = chercher_utilisateur_par_son_email_et_son_mot_de_passe($utilisateur['email'], $utilisateur['mot_de_passe']);
    if (!empty($utilisateur_connecter)) {
        $success = "Bravo!!! Vous est authentifié.";
        unset($utilisateur_connecter['mot-de-passe']);
        $_SESSION['utilisateur_connecter'] = $utilisateur_connecter;
    } else {
        $erreur = "Oups!!! Adresse mail ou mot de passe incorrect.";
    }
}

header('location: index.php?page=connexion&erreur=' . $erreur . '&erreurs=' . json_encode($erreurs)   . '&donnees=' . json_encode($donnees) . '&success=' . $success);

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

if (empty($_POST['prenoms'])) {
    $erreurs['prenoms'] = 'Le champ prénoms est obligatoire.';
}

if (empty($_POST['sexe'])) {
    $erreurs['sexe'] = 'Le champ sexe est obligatoire.';
} elseif ('M' !== $_POST['sexe'] && 'F' !== $_POST['sexe'] && 'A' !== $_POST['sexe']) {
    $erreurs['sexe'] = 'Le champ sexe a une valeur incorrect.';
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

if (empty($_POST['confirmer-mot-de-passe'])) {
    $erreurs['confirmer-mot-de-passe'] = 'Le champ de confirmation du mot de passe est obligatoire.';
} elseif (strlen($_POST['mot-de-passe']) < 8) {
    $erreurs['confirmer-mot-de-passe'] = 'Le champ de confirmation du mot de passe doit avoir une taille minimum de huit caractères.';
}

if (!empty($_POST['mot-de-passe']) && !empty($_POST['confirmer-mot-de-passe']) && $_POST['mot-de-passe'] !== $_POST['confirmer-mot-de-passe']) {
    $erreurs['mot-de-passe'] = $erreurs['confirmer-mot-de-passe'] = 'Le champ mot de passe et confirmation du mot de passe ne sont pas identique.';
}

if (empty($_POST['terms-conditions'])) {
    $erreurs['terms-conditions'] = 'Vous devez accepter les terms et conditions du site des recettes.';
}


if (empty($_POST) || !empty($erreurs)) {
    $erreur = "Oups!!! Un ou plusieur champs sont vide(s) ou mal(s) renseigné(s).";
} else {
    $utilisateur = $donnees;
    $utilisateur['mot_de_passe'] = sha1($utilisateur['mot-de-passe']);
    unset($utilisateur['confirmer-mot-de-passe']);
    unset($utilisateur['terms-conditions']);
    unset($utilisateur['mot-de-passe']);
    if(!chercher_utilisateur_par_son_email($utilisateur['email'])){
        $inscrire_utilisateur = inscrire_utilisateur($utilisateur);
        if ($inscrire_utilisateur) {
            $success = "Inscription effectuée avec succès.";
        } else {
            $erreur = "Oups!!! Une erreur est survenue lors de l'inscription.Veuille réessayer.";
        }
    }else{
        $erreur = "Oups!!! Une erreur est survenue lors de l'inscription.Veuille réessayer.";
        $erreurs['email'] = 'Le champ adresse email contient une valeur qui est déja utilisé.';
    }
}

header('location: index.php?page=inscription&erreur=' . $erreur . '&erreurs=' . json_encode($erreurs)   . '&donnees=' . json_encode($donnees) . '&success=' . $success);

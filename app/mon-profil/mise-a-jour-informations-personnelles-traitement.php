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

if (empty($_POST['mot-de-passe'])) {
    $erreurs['mot-de-passe'] = 'Le champ mot de passe est obligatoire.';
} elseif (strlen($_POST['mot-de-passe']) < 8) {
    $erreurs['mot-de-passe'] = 'Le champ mot de passe doit avoir une taille minimum de huit caractères.';
}

if (empty($_POST) || !empty($erreurs)) {
    $erreur = "Oups!!! Un ou plusieur champs sont vide(s) ou mal(s) renseigné(s).";
} else {

    $email = $_SESSION['utilisateur_connecter']['email'];
    $mot_de_passe = sha1($_POST['mot-de-passe']);

    $est_trouver = chercher_utilisateur_par_son_email_et_son_mot_de_passe($email, $mot_de_passe);

    if (empty($est_trouver)) {
        $erreur = "Oups!!! Le champ mot de passe est incorrect.";
        $erreurs['mot-de-passe'] = 'Le champ mot de passe est incorrect.';
    } else {
        $donnees_utilisateur = [
            'id_utilisateur' => $_SESSION['utilisateur_connecter']['id'],
            'nom' => $_POST['nom'],
            'prenoms' => $_POST['prenoms'],
            'sexe' => $_POST['sexe'],
        ];

        $est_mit_a_jour = modifier_utilisateur($donnees_utilisateur);
        if ($est_mit_a_jour) {
            $success = "Profil mit a jour avec succès.";
            $utilisateur_connecter = chercher_utilisateur_par_son_email_et_son_mot_de_passe($email, $mot_de_passe);
            $_SESSION['utilisateur_connecter'] = $utilisateur_connecter;
        } else {
            $erreur = "Oups!!! Une erreur est survenue lors de la mise a jour.Veuille réessayer.";
        }
    }
}

header('location: index.php?page=mon-profil&erreur=' . $erreur . '&erreurs=' . json_encode($erreurs)   . '&donnees=' . json_encode($donnees) . '&success=' . $success);

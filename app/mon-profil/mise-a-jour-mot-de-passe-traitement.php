<?php
$erreurs = [];
$donnees = [];
$success = '';
$erreur = '';

connexion_db();

foreach ($_POST as $cle => $valeur) {
    $donnees[$cle] = strip_tags($valeur);
}

if (empty($_POST['mot-de-passe-actuel'])) {
    $erreurs['mot-de-passe-actuel'] = 'Le champ mot de passe actuel est obligatoire.';
} elseif (strlen($_POST['mot-de-passe-actuel']) < 8) {
    $erreurs['mot-de-passe-actuel'] = 'Le champ mot de passe actuel doit avoir une taille minimum de huit caractères.';
}


if (empty($_POST['nouveau-mot-de-passe'])) {
    $erreurs['nouveau-mot-de-passe'] = 'Le champ nouveau mot de passe est obligatoire.';
} elseif (strlen($_POST['nouveau-mot-de-passe']) < 8) {
    $erreurs['nouveau-mot-de-passe'] = 'Le champ nouveau mot de passe doit avoir une taille minimum de huit caractères.';
}

if (empty($_POST['confirmer-nouveau-mot-de-passe'])) {
    $erreurs['confirmer-nouveau-mot-de-passe'] = 'Le champ de confirmation du nouveau mot de passe est obligatoire.';
} elseif (strlen($_POST['confirmer-nouveau-mot-de-passe']) < 8) {
    $erreurs['confirmer-nouveau-mot-de-passe'] = 'Le champ de confirmation du nouveau mot de passe doit avoir une taille minimum de huit caractères.';
}

if (!empty($_POST['nouveau-mot-de-passe']) && !empty($_POST['confirmer-nouveau-mot-de-passe']) && $_POST['nouveau-mot-de-passe'] !== $_POST['confirmer-nouveau-mot-de-passe']) {
    $erreurs['nouveau-mot-de-passe'] = $erreurs['confirmer-nouveau-mot-de-passe'] = 'Le champ nouveau mot de passe et confirmation du nouveau mot de passe ne sont pas identique.';
}

if (empty($_POST) || !empty($erreurs)) {
    $erreur = "Oups!!! Un ou plusieur champs sont vide(s) ou mal(s) renseigné(s).";
} else {
    $email = $_SESSION['utilisateur_connecter']['email'];
    $mot_de_passe = sha1($_POST['mot-de-passe-actuel']);

    $est_trouver = chercher_utilisateur_par_son_email_et_son_mot_de_passe($email, $mot_de_passe);

    if (empty($est_trouver)) {
        $erreur = "Oups!!! Le champ mot de passe est incorrect.";
        $erreurs['mot-de-passe'] = 'Le champ mot de passe est incorrect.';
    } else {
        $donnees_utilisateur = [
            'id_utilisateur' => $_SESSION['utilisateur_connecter']['id'],
            'mot_de_passe' => sha1($_POST['nouveau-mot-de-passe']),
        ];

        $est_mit_a_jour = modifier_mot_de_passe_utilisateur($donnees_utilisateur);
        if ($est_mit_a_jour) {
            $success = "Mot de passe mit a jour avec succès.";
            session_destroy();
        } else {
            $erreur = "Oups!!! Une erreur est survenue lors de la mise a jour.Veuille réessayer.";
        }
    }
}
if (empty($erreur)) {
    header('location: index.php?page=connexion&success=' . $success);
} else {
    header('location: index.php?page=mon-profil&erreur=' . $erreur . '&erreurs=' . json_encode($erreurs)   . '&donnees=' . json_encode($donnees) . '&success=' . $success);
}

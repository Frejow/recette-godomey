<?php
$erreurs = [];
$donnees = [];
$success = '';
$erreur = '';

connexion_db();

foreach ($_POST as $cle => $valeur) {
    $donnees[$cle] = strip_tags($valeur);
}

if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
    $erreur['email'] = 'Ce champs est obligatoire et doit contenir une adresse email valide';
} else {
    if (chercher_utilisateur_par_son_email($_POST['email'])) {
        if (mailSendin($_POST['email'], $_POST['email'], 'Mot de passe oublié', 'La demande de changement de votre mot de passe a été bien initialisé')) {
            $success = 'Un mail vient d\'être envoyé à votre adresse email';
        } else {
            $erreur = 'Une erreur s\'est produite lors de l\'envoi de l\'email';
        }
    } else {
        $erreur = 'Aucun utilisateur n\'a été trouvé avec cette adresse email.';
    }
}

header('location: index.php?page=inscription&erreur=' . $erreur . '&erreurs=' . json_encode($erreurs)   . '&donnees=' . json_encode($donnees) . '&success=' . $success);

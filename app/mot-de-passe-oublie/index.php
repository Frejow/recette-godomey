<?php

if (est_connecter()) {
    $message = "Vous êtes déja connecté. Veuillez poursuivre votre navigation.";
    header('location:index.php?page=accueil&message=' . $message);
}

$erreurs = [];
$donnees = [];
$erreur = '';
$success = '';

if (isset($_GET['erreurs']) && !empty($_GET['erreurs'])) {
    $erreurs = json_decode($_GET['erreurs'], true);
}

if (isset($_GET['donnees']) && !empty($_GET['donnees'])) {
    $donnees = json_decode($_GET['donnees'], true);
}

if (isset($_GET['erreur']) && !empty($_GET['erreur'])) {
    $erreur = $_GET['erreur'];
}

if (isset($_GET['success']) && !empty($_GET['success'])) {
    $success = $_GET['success'];
}


?>

<div class="row g-3 d-flex justify-content-center">
    <form class="col-md-6" action="index.php?page=traitement-mot-de-passe-oublie" method="POST" novalidate>
        <h3 class="text-center">
            Mot de passe oublié
        </h3>

        <p class="text-center">
            Veuillez fournir vos informations afin de vous envoyer de demande par mail pour réinitialiser votre mot de passe
        </p>


        <?php
        if (!empty($erreur)) {
        ?>
            <div class="alert alert-danger" role="alert">
                <?= $erreur; ?>
            </div>
        <?php
        }


        if (!empty($success)) {
        ?>
            <div class="alert alert-success" role="alert">
                <?= $success; ?>
            </div>
        <?php
        }
        ?>

        <div class="mb-3">
            <label for="inscription-email" class="form-label">
                Adresse email :
                <span class="text-danger">(*)</span>
            </label>
            <input type="email" name="email" class="form-control inscription-email" id="inscription-email" placeholder="Veuillez entrer votre adresse email." required value="<?= (isset($donnees['email']) && !empty($donnees['email'])) ? $donnees['email'] : '' ?>">
            <p class="text-danger">
                <?= (isset($erreurs['email']) && !empty($erreurs['email'])) ? $erreurs['email'] : '' ?>
            </p>
        </div>

        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>

    <a href="index.php?page=connexion" class="text-center">Je souhaite me contecter</a>
</div>
<?php

if (!est_connecter()) {
    $message = "Vous n'êtes pas connecté.";
    header('location:index.php?page=connexion&erreur=' . $message);
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

$donnees = array_merge($_SESSION['utilisateur_connecter'], $donnees);

?>

<h1 class="h1">
    Mon profil
</h1>

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

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                Mettre a jour ou modifier ces information personnelles :
            </div>
            <div class="card-body">
                <form action="index.php?page=mise-a-jour-informations-personnelles-traitement" method="POST" novalidate>
                    <p class="fw-bold">
                        Les champs avec <span class="text-danger">(*)</span> sont obligatoire.
                    </p>

                    <div class="mb-3">
                        <label for="mise-a-jour-informations-personnelles-nom" class="form-label">
                            Nom :
                            <span class="text-danger">(*)</span>
                        </label>
                        <input type="text" name="nom" class="form-control mise-a-jour-informations-personnelles-nom" id="mise-a-jour-informations-personnelles-nom" placeholder="Veuillez entrer votre nom de famille" required value="<?= (isset($donnees['nom']) && !empty($donnees['nom'])) ? $donnees['nom'] : '' ?>">
                        <p class="text-danger">
                            <?= (isset($erreurs['nom']) && !empty($erreurs['nom'])) ? $erreurs['nom'] : '' ?>
                        </p>
                    </div>

                    <div class="mb-3">
                        <label for="mise-a-jour-informations-personnelles-prenoms" class="form-label">
                            Prénoms :
                            <span class="text-danger">(*)</span>
                        </label>
                        <input type="text" name="prenoms" class="form-control mise-a-jour-informations-personnelles-prenoms" id="mise-a-jour-informations-personnelles-prenoms" placeholder="Veuillez entrer vos prénoms" required value="<?= (isset($donnees['prenoms']) && !empty($donnees['prenoms'])) ? $donnees['prenoms'] : '' ?>">
                        <p class="text-danger">
                            <?= (isset($erreurs['prenoms']) && !empty($erreurs['prenoms'])) ? $erreurs['prenoms'] : '' ?>
                        </p>
                    </div>

                    <div class="mb-3">
                        <label for="mise-a-jour-informations-personnelles-sexe" class="form-label">
                            Sexe :
                            <span class="text-danger">(*)</span>
                        </label>
                        <select name="sexe" class="form-select mise-a-jour-informations-personnelles-sexe" id="mise-a-jour-informations-personnelles-sexe">
                            <option <?= (!isset($donnees['sexe']) || !empty($donnees['sexe'])) ? 'selected' : '' ?>>Selectionner votre sexe</option>
                            <option value="M" <?= (isset($donnees['sexe']) && !empty($donnees['sexe']) && $donnees['sexe'] === "M") ? 'selected' : '' ?>>Homme</option>
                            <option value="F" <?= (isset($donnees['sexe']) && !empty($donnees['sexe']) && $donnees['sexe'] === "F") ? 'selected' : '' ?>>Femme</option>
                            <option value="A" <?= (isset($donnees['sexe']) && !empty($donnees['sexe']) && $donnees['sexe'] === "A") ? 'selected' : '' ?>>Autre</option>
                        </select>
                        <p class="text-danger">
                            <?= (isset($erreurs['sexe']) && !empty($erreurs['sexe'])) ? $erreurs['sexe'] : '' ?>
                        </p>
                    </div>

                    <div class="mb-3">
                        <label for="mise-a-jour-informations-personnelles-mot-de-passe" class="form-label">
                            Mot de passe actuel :
                            <span class="text-danger">(*)</span>
                        </label>
                        <input type="password" name="mot-de-passe" class="form-control mise-a-jour-informations-personnelles-mot-de-passe" id="mise-a-jour-informations-personnelles-mot-de-passe" placeholder="Veuillez entrer votre mot de passe." required value="<?= (isset($donnees['mot-de-passe']) && !empty($donnees['mot-de-passe'])) ? $donnees['mot-de-passe'] : '' ?>">
                        <p class="text-danger">
                            <?= (isset($erreurs['mot-de-passe']) && !empty($erreurs['mot-de-passe'])) ? $erreurs['mot-de-passe'] : '' ?>
                        </p>
                    </div>

                    <button type="submit" class="btn btn-warning">Modifier mon profil</button>
                </form>
            </div>
        </div>
    </div>


    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                Mettre a jour son mot de passe
            </div>
            <div class="card-body">
                <form action="index.php?page=mise-a-jour-mot-de-passe-traitement" method="POST" novalidate>
                    <p class="fw-bold">
                        Les champs avec <span class="text-danger">(*)</span> sont obligatoire.
                    </p>

                    <div class="mb-3">
                        <label for="mise-a-jour-mot-de-passe-mot-de-passe-actuel" class="form-label">
                            Mot de passe actuel :
                            <span class="text-danger">(*)</span>
                        </label>
                        <input type="password" name="mot-de-passe-actuel" class="form-control mise-a-jour-mot-de-passe-mot-de-passe-actuel" id="mise-a-jour-mot-de-passe-mot-de-passe-actuel" placeholder="Veuillez entrer votre mot de passe actuel." required value="<?= (isset($donnees['mot-de-passe-actuel']) && !empty($donnees['mot-de-passe-actuel'])) ? $donnees['mot-de-passe-actuel'] : '' ?>">
                        <p class="text-danger">
                            <?= (isset($erreurs['mot-de-passe-actuel']) && !empty($erreurs['mot-de-passe-actuel'])) ? $erreurs['mot-de-passe-actuel'] : '' ?>
                        </p>
                    </div>

                    <div class="mb-3">
                        <label for="mise-a-jour-mot-de-passe-nouveau-mot-de-passe" class="form-label">
                            Nouveau mot de passe :
                            <span class="text-danger">(*)</span>
                        </label>
                        <input type="password" name="nouveau-mot-de-passe" class="form-control mise-a-jour-mot-de-passe-nouveau-mot-de-passe" id="mise-a-jour-mot-de-passe-nouveau-mot-de-passe" placeholder="Veuillez entrer votre nouveau mot de passe." required value="<?= (isset($donnees['nouveau-mot-de-passe']) && !empty($donnees['nouveau-mot-de-passe'])) ? $donnees['nouveau-mot-de-passe'] : '' ?>">
                        <p class="text-danger">
                            <?= (isset($erreurs['nouveau-mot-de-passe']) && !empty($erreurs['nouveau-mot-de-passe'])) ? $erreurs['nouveau-mot-de-passe'] : '' ?>
                        </p>
                    </div>

                    <div class="mb-3">
                        <label for="mise-a-jour-mot-de-passe-confirmer-nouveau-mot-de-passe" class="form-label">
                            Confirmer nouveau mot de passe :
                            <span class="text-danger">(*)</span>
                        </label>
                        <input type="password" name="confirmer-nouveau-mot-de-passe" class="form-control mise-a-jour-mot-de-passe-confirmer-nouveau-mot-de-passe" id="mise-a-jour-mot-de-passe-confirmer-nouveau-mot-de-passe" placeholder="Veuillez entrer confirmer le nouveau mot de passe." required value="<?= (isset($donnees['confirmer-nouveau-mot-de-passe']) && !empty($donnees['confirmer-nouveau-mot-de-passe'])) ? $donnees['confirmer-nouveau-mot-de-passe'] : '' ?>">
                        <p class="text-danger">
                            <?= (isset($erreurs['confirmer-nouveau-mot-de-passe']) && !empty($erreurs['confirmer-nouveau-mot-de-passe'])) ? $erreurs['confirmer-nouveau-mot-de-passe'] : '' ?>
                        </p>
                    </div>

                    <button type="submit" class="btn btn-warning">Modifier mon profil</button>
                </form>
            </div>
        </div>
    </div>
</div>
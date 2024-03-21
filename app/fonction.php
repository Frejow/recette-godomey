<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function mailSendin(string $destination, string $recipient, string $subject, string $body): bool
{
    // passing true in constructor enables exceptions in PHPMailer
    $mail = new PHPMailer(true);
    $mail->CharSet = "UTF-8";

    try {

        // Server settings
        // for detailed debug output
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->Username = 'recettegodomey@gmail.com';
        $mail->Password = 'xrqwxcdiiwgsklet';

        // Sender and recipient settings
        $mail->setFrom('recettegodomey@gmail.com', htmlspecialchars_decode('Recette Godomey'));
        $mail->addAddress($destination, $recipient);
        $mail->addReplyTo('recettegodomey@gmail.com', htmlspecialchars_decode('Recette Godomey'));

        // Setting the email content
        $mail->IsHTML(true);
        $mail->Subject = htmlspecialchars_decode($subject);
        $mail->Body = $body;

        return $mail->send();
    } catch (Exception $e) {

        return false;
    }
}

/**
 * Cette fonction permet de se connecter la base de données.
 * @return PDO | string L'instance de la base de données ou le message d'erreur.
 */
function connexion_db()
{
    try {
        $dns = 'mysql:host=localhost;dbname=recette;charset=utf8';
        $user_name = 'root';
        $password = '';
        return new PDO($dns, $user_name, $password);
    } catch (Exception $e) {
        return $e->getMessage();
    }
}

/**
 * Cette fonction permet d'inscrire un utilisateur.
 * 
 * @param array $utilisateur Les informtion de l'utilisateur.
 * @return bool $inscrire_utilisateur Es ce que l'utilisateur a pu etre inscrit.
 */
function inscrire_utilisateur($utilisateur)
{
    $inscrire_utilisateur = false;

    $db = connexion_db();

    if (is_object($db)) {
        $requetteSql = 'INSERT INTO utilisateur(`nom`, `prenoms`, `sexe`, `email`, `mot-de-passe`) VALUES (:nom,:prenoms,:sexe,:email,:mot_de_passe)';
        $requette = $db->prepare($requetteSql);
        try {
            $inscrire_utilisateur = $requette->execute($utilisateur);
        } catch (Exception $e) {
            $inscrire_utilisateur = false;
        }
    }

    return $inscrire_utilisateur;
}

/**
 * Cette fonction permet de verifier si un utilisateur existe dans la base de données grace a son adresse email.
 * 
 * @param string $email L'adresse email de l'utilisateur.
 * @return bool
 */
function chercher_utilisateur_par_son_email(string $email): bool
{
    $utilisateur_est_trouver = false;

    $db = connexion_db();

    if (is_object($db)) {
        $requetteSql = 'SELECT * FROM `utilisateur` WHERE email =:email';
        $requette = $db->prepare($requetteSql);
        try {
            $requette->execute(['email' => $email]);
            if (is_array($requette->fetch(PDO::FETCH_ASSOC))) {
                $utilisateur_est_trouver = true;
            }
        } catch (Exception $e) {
            $utilisateur_est_trouver = false;
        }
    }

    return $utilisateur_est_trouver;
}



/**
 * Cette fonction permet de verifier si un utilisateur existe dans la base de données grace a son adresse email et son mot de passe.
 * 
 * @param string $email L'adresse email de l'utilisateur.
 * @param string $mot_de_passe Le mot de passe de l'utilisateur.
 * @return bool
 */
function chercher_utilisateur_par_son_email_et_son_mot_de_passe(string $email, string $mot_de_passe): array
{
    $utilisateur_est_trouver = [];

    $db = connexion_db();

    if (is_object($db)) {
        $requetteSql = 'SELECT * FROM `utilisateur` WHERE `email`=:email and `mot-de-passe`=:mot_de_passe';
        $requette = $db->prepare($requetteSql);
        try {

            $requette->execute(
                [
                    'email' => $email,
                    'mot_de_passe' => $mot_de_passe
                ]
            );
            $utilisateur = $requette->fetch(PDO::FETCH_ASSOC);
            if (is_array($utilisateur)) {
                $utilisateur_est_trouver =  $utilisateur;
            }
        } catch (Exception $e) {
            $utilisateur_est_trouver = [];
        }
    }

    return $utilisateur_est_trouver;
}

/**
 * Cette fonction me permet de verifier si un utilisateur est connecté.
 * 
 * @return bool
 */
function est_connecter(): bool
{
    $est_connecter = false;
    if (isset($_SESSION['utilisateur_connecter']) && !empty($_SESSION['utilisateur_connecter'])) {
        $est_connecter = chercher_utilisateur_par_son_email($_SESSION['utilisateur_connecter']['email']);
        if ($est_connecter) {
            return true;
        } else {
            session_destroy();
        }
    }

    return $est_connecter;
}

/**
 * Cette fonction permet d'ajouter une recette dans la base de données.
 * 
 * @param array $donnees_recette Les données de la recette a créer.
 * @return bool
 */
function ajout_recette(array $donnees_recette): bool
{
    $est_ajouter = false;

    $db = connexion_db();

    if (is_object($db)) {
        $requetteSql = 'INSERT INTO recette(`nom`, `description`, `recette`, `image`, `id_utilisateur`) VALUES (:nom,:description,:recette,:image,:id_utilisateur)';
        $requette = $db->prepare($requetteSql);
        try {
            $est_ajouter = $requette->execute($donnees_recette);
        } catch (Exception $e) {
            $est_ajouter = false;
        }
    }

    return $est_ajouter;
}

function enregistrer_une_image($nom_du_champ): bool|string
{
    $est_enregistrer = false;
    // Testons si le fichier a bien été envoyé et s'il n'y a pas des erreurs
    if (isset($_FILES[$nom_du_champ]) && $_FILES[$nom_du_champ]['error'] === 0) {
        // Testons, si le fichier est trop volumineux
        if ($_FILES[$nom_du_champ]['size'] > 1000000) {
            return "L'envoi n'a pas pu être effectué, erreur ou image trop volumineuse";
        }
        // Testons, si l'extension n'est pas autorisée
        $fileInfo = pathinfo($_FILES[$nom_du_champ]['name']);
        $extension = $fileInfo['extension'];
        $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];
        if (!in_array($extension, $allowedExtensions)) {
            return "L'envoi n'a pas pu être effectué, l'extension {$extension} n'est pas autorisée";
        }

        // Testons, si le dossier uploads est manquant
        $path = __DIR__ . '/uploads/';
        if (!is_dir($path)) {
            mkdir($path);
            return "L'envoi n'a pas pu être effectué, le dossier uploads est manquant";
        }

        // On peut valider le fichier et le stocker définitivement
        $est_enregistrer  =  move_uploaded_file($_FILES[$nom_du_champ]['tmp_name'], $path . basename($_FILES[$nom_du_champ]['name']));

        return $est_enregistrer;
    }
    return -1;
}

/**
 * Cette fonction permet de recupere la liste des recettes diponible u ceux appartenant a un utilisateur.
 * 
 * @param int|null $id_utilisateur L'id de l'utilisateur.
 * @param int $nombre_de_recette_par_page Le nombre de recette par page.
 * @param int $numero_de_page Le numero de la page.
 * @return array $recettes La liste des recettes.
 */
function recettes(int $id_utilisateur = null, int $nombre_de_recette_par_page = 10, int $numero_de_page = 1): array
{
    $recettes = [];

    $db = connexion_db();

    if (is_object($db)) {
        $requetteSql = 'SELECT * FROM `recette`';

        if (!is_null($id_utilisateur)) {
            $requetteSql = $requetteSql . ' WHERE `id_utilisateur`=:id_utilisateur';
        }

        $requetteSql = $requetteSql . ' limit ' . $nombre_de_recette_par_page . ' offset ' . ($nombre_de_recette_par_page * ($numero_de_page - 1));

        $requette = $db->prepare($requetteSql);

        try {
            $donnees = [];

            if (!is_null($id_utilisateur)) {
                $donnees['id_utilisateur'] = $id_utilisateur;
            }

            $requette->execute($donnees);
            $recettes = $requette->fetchAll(PDO::FETCH_ASSOC);
            if (is_array($recettes)) {
                $recettes =  $recettes;
            }
        } catch (Exception $e) {
            $recettes = [];
        }
    }

    return $recettes;
}

/**
 * Cette fonction permet de recupere une recette grace a son id.
 * 
 * @param int $id_recette L'id de la recette.
 * @return array $recette Les informations d'une recette.
 */
function recette(int $id_recette): array
{
    $recette = [];

    $db = connexion_db();

    if (is_object($db)) {
        $requetteSql = 'SELECT * FROM `recette` WHERE `id`=:id_recette';

        $requette = $db->prepare($requetteSql);
        try {
            $requette->execute([
                'id_recette' => $id_recette
            ]);
            $recette = $requette->fetch(PDO::FETCH_ASSOC);
            if (is_array($recette)) {
                $recette =  $recette;
            } else {
                $recette = [];
            }
        } catch (Exception $e) {
            $recette = [];
        }
    }

    return $recette;
}

/**
 * Cette fonction permet de mettre a jour une recette dans la base de données.
 * 
 * @param array $donnees_recette Les données de la recette a mettre a jour.
 * @return bool
 */
function modifier_recette(array $donnees_recette): bool
{
    $est_modifier = false;

    $db = connexion_db();

    if (is_object($db)) {
        $requetteSql = 'UPDATE `recette` SET `nom`=:nom,`description`=:description,`recette`=:recette,`image`=:image WHERE `id` = :id_recette';
        $requette = $db->prepare($requetteSql);
        try {
            $est_modifier = $requette->execute($donnees_recette);
        } catch (Exception $e) {
            $est_modifier = false;
        }
    }

    return $est_modifier;
}


function supprimer_recette(int $id_recette): bool
{
    $est_supprimer = false;

    $db = connexion_db();

    if (is_object($db)) {
        $requetteSql = 'DELETE FROM `recette` WHERE `id` = :id_recette';
        $requette = $db->prepare($requetteSql);
        try {
            $est_supprimer = $requette->execute([
                'id_recette' => $id_recette
            ]);
        } catch (Exception $e) {
            $est_supprimer = false;
        }
    }

    return $est_supprimer;
}

/**
 * Cette fonction permet de compter le nombre de recette qu'il y a dans la base de donnees.
 * 
 * @param int|null $id_utilisateur L'id de l'utilisateur.
 * @return int $nombre_de_recette_dans_la_base_de_donnees Le nombre de recette dans la base de donnees.
 */
function nombre_de_recette_dans_la_base_de_donnees(int $id_utilisateur = null): int
{
    $nombre_de_recette_dans_la_base_de_donnees = 0;

    $db = connexion_db();

    if (is_object($db)) {
        $requetteSql = 'SELECT count(*) as total FROM `recette`';

        if (!is_null($id_utilisateur)) {
            $requetteSql = $requetteSql . ' WHERE `id_utilisateur`=:id_utilisateur';
        }

        $requette = $db->prepare($requetteSql);

        try {
            $donnees = [];

            if (!is_null($id_utilisateur)) {
                $donnees['id_utilisateur'] = $id_utilisateur;
            }

            $requette->execute($donnees);
            $requetteTotal = $requette->fetch(PDO::FETCH_ASSOC);

            if (is_array($requetteTotal)) {
                $nombre_de_recette_dans_la_base_de_donnees =  $requetteTotal['total'];
            }
        } catch (Exception $e) {
            $nombre_de_recette_dans_la_base_de_donnees = 0;
        }
    }

    return $nombre_de_recette_dans_la_base_de_donnees;
}

/**
 * Cette fonction permet de mettre a jour un utilisateur dans la base de données.
 * 
 * @param array $donnees_utilisateur Les données de l'utilisateur a mettre a jour.
 * @return bool
 */
function modifier_utilisateur(array $donnees_utilisateur): bool
{
    $est_modifier = false;

    $db = connexion_db();

    if (is_object($db)) {
        $requetteSql = 'UPDATE `utilisateur` SET `nom`=:nom, `prenoms`=:prenoms,`sexe`=:sexe WHERE`id` = :id_utilisateur';

        $requette = $db->prepare($requetteSql);
        try {
            $est_modifier = $requette->execute($donnees_utilisateur);
        } catch (Exception $e) {
            $est_modifier = false;
        }
    }

    return $est_modifier;
}

/**
 * Cette fonction permet de mettre a jour le mot de passe d'un utilisateur dans la base de données.
 * 
 * @param array $donnees_utilisateur Les données de l'utilisateur a mettre a jour.
 * @return bool
 */
function modifier_mot_de_passe_utilisateur(array $donnees_utilisateur): bool
{
    $est_modifier = false;

    $db = connexion_db();

    if (is_object($db)) {
        $requetteSql = 'UPDATE `utilisateur` SET `mot-de-passe`=:mot_de_passe WHERE`id` = :id_utilisateur';

        $requette = $db->prepare($requetteSql);
        try {
            $est_modifier = $requette->execute($donnees_utilisateur);
        } catch (Exception $e) {
            $est_modifier = false;
        }
    }

    return $est_modifier;
}

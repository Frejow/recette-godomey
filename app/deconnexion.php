<?php
if (isset($_SESSION['utilisateur_connecter']) && !empty($_SESSION['utilisateur_connecter'])) {
    session_destroy();
}

header('location: index.php?page=accueil');

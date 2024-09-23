<?php
session_start();

// Supprimer les cookies en les réinitialisant avec une date d'expiration passée
setcookie('username', '', time() - 3600, "/");
setcookie('role', '', time() - 3600, "/");

// Détruire toutes les variables de session
session_unset();

// Détruire la session
session_destroy();

// Redirection vers la page de connexion
header("Location: /login/index.php");
exit();
?>

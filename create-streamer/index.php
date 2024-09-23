<?php
session_start();
require 'db.php';  // Inclure le fichier de connexion à la base de données

// Initialisation de la variable d'erreur
$error = "";
$success = false;

// Vérification si la requête est POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Vérification si le mot de passe et sa confirmation correspondent
    if ($password != $confirm_password) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        // Vérification si l'utilisateur existe déjà
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $error = "Ce nom d'utilisateur est déjà pris. Veuillez en choisir un autre.";
        } else {
            // Hachage du mot de passe
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insertion de l'utilisateur avec le rôle 'streamer'
            $stmt = $pdo->prepare('INSERT INTO users (username, password, role) VALUES (:username, :password, :role)');
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindValue(':role', 'streamer');  // Le rôle est défini par défaut sur 'streamer'

            if ($stmt->execute()) {
                $success = true;
                // Stocker un message dans la session pour l'afficher après redirection
                $_SESSION['message'] = "Compte créé avec succès. Bienvenue, " . htmlspecialchars($username) . "!";
                // Redirection vers le tableau de bord de l'admin
                header("Location: /admin-dashboard/index.php");
                exit();
            } else {
                $error = "Erreur lors de la création du compte.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Z Event - Create Streamer</title>

    <!-- Ajout du script pour gérer les alertes en fonction du succès ou de l'erreur -->
    <script type="text/javascript">
        <?php if (!empty($error)): ?>
            alert("Erreur : <?= htmlspecialchars($error) ?>");
        <?php elseif ($success): ?>
            alert("Compte créé avec succès !");
        <?php endif; ?>
    </script>
</head>
<body>

<header>
    <button class="logo-button" href="/home/index.php/"><img src="assets/logo.png" class="logo" alt="logo"></button>
    <span class="header-title">Z Event</span>
    <button class="menu-button" id="open-menu"><img src="assets/menu.svg" class="menu" alt="menu"></button>
    <link rel="apple-touch-icon" sizes="180x180" href="assets/ico/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/ico/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/ico/favicon-16x16.png">
    <link rel="manifest" href="assets/ico/site.webmanifest">
    <link rel="mask-icon" href="assets/ico/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
</header>

<nav id="side-menu" class="side-menu">
    <button class="close-button" id="close-menu">&times;</button>
    <ul>
        <li><a href="/home/index.php">Acceuil</a></li>
        <li><a href="/live/index.php">Stream en direct</a></li>
        <li><a href="/fundraised/index.php">Cagnotte</a></li>
        <li><a href="/menu/index.php">Menu Visiteur</a></li>
        <li><a href="/login/index.php">Connexion</a></li>
        <li><a href="/logout/index.php">Déconnexion</a></li>
    </ul>
</nav>

<div class="sign-up-wrapper">
    <div class="sign-up-container">
        <h1>Create Streamer</h1>
        <p>Enter your username and password to access your account.</p>

        <?php if (!empty($error)): ?>
            <p class="error" style="color: red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" action="index.php">
            <div class="input-container">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
            </div>

            <div class="input-container">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>

            <div class="input-container">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
            </div>

            <button type="submit" class="sign-up-btn">Sign Up</button>
        </form>
    </div>
</div>

<footer>
    <p>&copy; 2024 Z-Event. Tous droits réservés.</p>
    <div class="footer-links">
        <a href="#" class="footer-link">Conditions d'utilisation</a>
        <a href="#" class="footer-link">Politique de confidentialité</a>
    </div>
</footer>

<script src="script.js"></script>

</body>
</html>

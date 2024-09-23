<?php
session_start();
require 'db.php';

// Vérifier si l'utilisateur est déjà connecté via les cookies ou la session
if (isset($_COOKIE['username']) && isset($_COOKIE['role'])) {
    // Redirection basée sur le rôle
    if ($_COOKIE['role'] == 'admin') {
        header("Location: /admin-dashboard/index.php");
        exit();
    } elseif ($_COOKIE['role'] == 'streamer') {
        header("Location: /streamer-dashboard/index.php");
        exit();
    }
}

// Traitement du formulaire de connexion
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Requête SQL pour vérifier l'utilisateur
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Vérifier le mot de passe
        if (password_verify($password, $user['password'])) {
            // Connexion réussie, définir les cookies et la session
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Définir les cookies avec expiration (7 jours)
            setcookie('username', $user['username'], time() + (86400 * 7), "/", "", true, true);
            setcookie('role', $user['role'], time() + (86400 * 7), "/", "", true, true);

            // Redirection basée sur le rôle
            if ($user['role'] == 'admin') {
                header("Location: /admin-dashboard/index.php");
            } elseif ($user['role'] == 'streamer') {
                header("Location: /streamer-dashboard/index.php");
            }
            exit();
        } else {
            echo "Mot de passe incorrect.";
        }
    } else {
        echo "Utilisateur non trouvé.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Z Event - Login</title>
    <link rel="apple-touch-icon" sizes="180x180" href="assets/ico/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/ico/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/ico/favicon-16x16.png">
    <link rel="manifest" href="assets/ico/site.webmanifest">
    <link rel="mask-icon" href="assets/ico/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
</head>
<body>

<header>
    <button class="logo-button" href="/home/index.php/"><img src="assets/logo.png" class="logo" alt="logo"></button>
    <span class="header-title">Z Event</span>
    <button class="menu-button" id="open-menu"><img src="assets/menu.svg" class="menu" alt="menu"></button>
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
        <h1>Login</h1>
        <p>Enter your username and password to log in to your account.</p>

        <!-- Formulaire de connexion -->
        <form method="POST" action="authenticate.php">
            <div class="input-container">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
            </div>

            <div class="input-container">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>

            <button type="submit" class="sign-up-btn">Login</button>
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

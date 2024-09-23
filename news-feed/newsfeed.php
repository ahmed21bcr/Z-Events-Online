<?php
session_start();
require 'db.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['username'])) {
    header("Location: /login/index.php");
    exit();
}

// Traitement du formulaire d'ajout de post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_SESSION['username'];

    // Insertion du post dans la base de données
    $stmt = $pdo->prepare('INSERT INTO posts (title, content, author) VALUES (:title, :content, :author)');
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':author', $author);

}

// Récupérer les articles depuis la base de données
$stmt = $pdo->prepare('SELECT * FROM posts ORDER BY created_at DESC');
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Fil d'actualité - Z Event</title>
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
        <li><a href="/logout/logout.php">Déconnexion</a></li>
    </ul>
</nav>

<section class="latest-news">
    <div class="latest-news-wrapper">
        <div class="news-text">
            <h2>Dernières Nouvelles</h2>

            <!-- Formulaire de publication -->
            <form method="POST" action="newsfeed.php" class="post-form">
                <div class="input-container">
                    <label for="title">Titre</label>
                    <input type="text" id="title" name="title" placeholder="Entrez le titre" required>
                </div>

                <div class="input-container">
                    <label for="content">Contenu</label>
                    <textarea id="content" name="content" placeholder="Entrez le contenu" required></textarea>
                </div>

                <button type="submit" class="button">Publier</button>
            </form>

            <h2>Actualités récentes</h2>

            <!-- Affichage des articles -->
            <?php foreach ($posts as $post): ?>
                <div class="post">
                    <h1><?php echo htmlspecialchars($post['title']); ?></h1>
                    <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                    <p class="date"><?php echo $post['created_at']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

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

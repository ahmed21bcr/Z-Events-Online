<?php
session_start();
// Database connection configuration
$host = 'ixnzh1cxch6rtdrx.cbetxkdyhwsb.us-east-1.rds.amazonaws.com';  // Adjust if necessary
$dbname = 'tjmzqsfikd7skftg';  // Your database name
$username = 'ls4erapz4hg0t1fs';  // Your database username
$password = 'fddb6ge7gda6pzkb';  // Your database password

try {
    // Connect to the MySQL database using PDO with SSL disabled (if needed)
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, array(
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
    ));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Vérification si l'utilisateur est connecté
$userRole = null;
if (isset($_SESSION['user_id'])) {
    // Requête pour récupérer le rôle de l'utilisateur
    $stmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    if ($user) {
        $userRole = $user['role'];
    }
}

// Récupérer les nouvelles pour le fil d'actualité
$stmt = $pdo->prepare("SELECT title, content, published_at FROM news_feed ORDER BY published_at DESC LIMIT 5");
$stmt->execute();
$newsFeed = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Z Event - Visitor Page</title>
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

<section class="visitor-page">
    <h2>Welcome to Z Event</h2>

    <!-- Fil d'actualité -->
    <section class="news-feed">
        <h3>Fil d'actualité</h3>
        <?php if (!empty($newsFeed)): ?>
            <?php foreach ($newsFeed as $news): ?>
                <div class="news-item">
                    <p><strong><?= htmlspecialchars($news['title']) ?></strong></p>
                    <p><?= htmlspecialchars($news['content']) ?></p>
                    <p>Publié le : <?= htmlspecialchars(date("d/m/Y H:i", strtotime($news['published_at']))) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucune actualité pour le moment.</p>
        <?php endif; ?>
    </section>

    <!-- Live Streams Section -->
    <section class="live-section">
        <h3>Live Streams Online</h3>
        <section class="streamer-count">
            <?php
            // Requête pour compter le nombre de lives dans la table `streams`
            $sql = "SELECT COUNT(*) AS total_lives FROM streams";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // Affichage du nombre de lives
            $total_lives = $result['total_lives'];
            echo "<p>Nombre total de lives: $total_lives</p>";
            ?>
    </section>

    <!-- Vue globale de tous les lives -->
    <section class="all-lives-section">
        <h3>Vue globale de tous les lives</h3>

        <?php if (!empty($liveStreams)): ?>
            <div class="all-lives">
                <?php foreach ($liveStreams as $stream): ?>
                    <div class="live-item">
                        <p class="title"><?= htmlspecialchars($stream['username']) ?></p>
                        <p>Viewers: <?= htmlspecialchars($stream['viewers']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Aucun live en cours.</p>
        <?php endif; ?>
    </section>

</section>

<script src="script.js"></script>

</body>


<footer>
    <p>&copy; 2024 Z-Event. Tous droits réservés.</p>
    <div class="footer-links">
        <a href="#" class="footer-link">Conditions d'utilisation</a>
        <a href="#" class="footer-link">Politique de confidentialité</a>
    </div>
</footer>
</html>

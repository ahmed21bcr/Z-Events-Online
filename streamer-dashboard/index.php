<?php
session_start();

// Vérification si les cookies existent
if (isset($_COOKIE['username']) && isset($_COOKIE['role'])) {
    $username = htmlspecialchars($_COOKIE['username']);
    $role = htmlspecialchars($_COOKIE['role']);
} else {
    echo "Veuillez vous connecter.";
    header("Location: /login/index.php");
    exit();
}

// Inclure la connexion à la base de données
include 'db.php';

// Récupérer le total des clics depuis la base de données
$sql = "SELECT SUM(clicks) as total_clicks FROM viewer_statistics";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetch();

// Si le résultat est null, on affiche 0
$totalClicks = $result['total_clicks'] ? $result['total_clicks'] : 0;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Z Event</title>
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

<section class="live-actions">
    <h2>Streamer Menu</h2>
    <hr>

    <div class="streamer-controls">
        <div class="control-group">
            <h3>Create Stream</h3>
            <p class="description">Start a new live stream</p>
            <button class="go-live-btn" onclick="window.location.href='/create-live/index.php'">Go Live</button>
        </div>

        <div class="control-group">
            <h3>Cancel/Stop Live</h3>
            <p class="description">Cancel any scheduled live stream or any active live stream</p>
            <button class="cancel-btn" onclick="window.location.href='/delete-live/index.php'">Cancel/Stop</button>

            <?php
            // Récupérer tous les streams
            $sql = "SELECT id, title FROM streams";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $streams = $stmt->fetchAll();

            if ($streams) {
                echo "<ul>";
                foreach ($streams as $stream) {
                    echo "<li>" . htmlspecialchars($stream['title']) . " 
                          <a href='stop_stream.php?id=" . $stream['id'] . "'>Arrêter le stream</a></li>";
                }
                echo "</ul>";
            } else {
                echo "<p>Aucun stream trouvé.</p>";
            }
            ?>
        </div>
    </div>

    <div class="live-stats">
        <h3>Live Statistics</h3>
        <div class="stats-grid">
            <div>
                <span class="stats-number"><?php echo $totalClicks; ?></span>
                <p>Clics</p>
            </div>
        </div>
    </div>

    <div class="live-qa">
    <?php foreach ($posts as $post): ?>
                <div class="post">
                    <h1><?php echo htmlspecialchars($post['title']); ?></h1>
                    <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                    <p class="date"><?php echo $post['created_at']; ?></p>
                </div>
            <?php endforeach; ?>
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

<?php
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
?>

<!DOCTYPE html>
<html lang="fr">
<script src="script.js"></script>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Z Event - Lives</title>
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
        <li><a href="/home/index.php">Accueil</a></li>
        <li><a href="/live/index.php">Stream en direct</a></li>
        <li><a href="/fundraised/index.php">Cagnotte</a></li>
        <li><a href="/menu/index.php">Menu Visiteur</a></li>
        <li><a href="/login/index.php">Connexion</a></li>
        <li><a href="/logout/index.php">Déconnexion</a></li>
    </ul>
</nav>

<!-- Section pour les Lives en cours ou terminés -->
<section class="popular-lives">
    <h2>Lives</h2>
    <div class="float-container">
        <?php
        // Récupérer les lives en cours ou terminés
        $stmt = $conn->query("SELECT id, title, thematic, pegi_rating, description, material, start_time, end_time 
                              FROM streams 
                              WHERE start_time <= NOW() 
                              ORDER BY start_time ASC");

        while ($live = $stmt->fetch()) {
            echo '<div class="float-child">
                    <div class="container">
                        <div class="card">
                            <div class="preview">
                                <img src="afficher_image.php?id=' . $live['id'] . '" alt="Preview of ' . htmlspecialchars($live['title']) . '" width="280" height="170">
                            </div>
                            <h1>' . htmlspecialchars($live['title']) . '</h1>
                            <p>Thematic: ' . htmlspecialchars($live['thematic']) . '</p>
                            <p>PEGI Rating: ' . htmlspecialchars($live['pegi_rating']) . '</p>
                            <p>Description: ' . htmlspecialchars($live['description']) . '</p>
                            <p>Material: ' . htmlspecialchars($live['material']) . '</p>
                            <p>Date de début: ' . htmlspecialchars($live['start_time']) . '</p>
                            <p>Date de fin: ' . htmlspecialchars($live['end_time']) . '</p>
                            <!-- Lien pour accéder à la page de détails du live avec appel à clics.php -->
                            <a class="look-button" href="live.php?id=' . $live['id'] . '" onclick="registerClick(event, ' . $live['id'] . ', \'' . htmlspecialchars($live['title']) . '\')">Voir le live</a>
                        </div>
                    </div>
                  </div>';
        }
        ?>
    </div>
</section>

<!-- Section pour les Lives à venir -->
<section class="upcoming-lives">
    <h2>Upcoming Lives</h2>
    <div class="float-container">
        <?php
        // Récupérer les lives à venir
        $stmt = $conn->query("SELECT id, title, thematic, pegi_rating, description, material, start_time, end_time 
                              FROM streams 
                              WHERE start_time > NOW() 
                              ORDER BY start_time ASC");

        while ($live = $stmt->fetch()) {
            echo '<div class="float-child">
                    <div class="container">
                        <div class="card">
                            <div class="preview">
                                <img src="afficher_image.php?id=' . $live['id'] . '" alt="Preview of ' . htmlspecialchars($live['title']) . '" width="280" height="170">
                            </div>
                            <h1>' . htmlspecialchars($live['title']) . '</h1>
                            <p>Thematic: ' . htmlspecialchars($live['thematic']) . '</p>
                            <p>PEGI Rating: ' . htmlspecialchars($live['pegi_rating']) . '</p>
                            <p>Description: ' . htmlspecialchars($live['description']) . '</p>
                            <p>Material: ' . htmlspecialchars($live['material']) . '</p>
                            <p>Date de début: ' . htmlspecialchars($live['start_time']) . '</p>
                            <p>Date de fin: ' . htmlspecialchars($live['end_time']) . '</p>
                            <!-- Lien pour accéder à la page de détails du live avec appel à clics.php -->
                            <a class="look-button" href="live.php?id=' . $live['id'] . '" onclick="registerClick(event, ' . $live['id'] . ', \'' . htmlspecialchars($live['title']) . '\')">Voir le live</a>
                        </div>
                    </div>
                  </div>';
        }
        ?>
    </div>
</section>

</body>
<footer>
    <p>&copy; 2024 Z Event. Tous droits réservés.</p>
    <div class="footer-links">
        <a href="#" class="footer-link">Conditions d'utilisation</a>
        <a href="#" class="footer-link">Politique de confidentialité</a>
    </div>
</footer>
</html>

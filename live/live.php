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

// Vérifier que l'ID du live est fourni dans l'URL
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Préparer et exécuter la requête pour récupérer les détails du live
    $stmt = $conn->prepare("SELECT title, thematic, pegi_rating, description, preview_image FROM streams WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $live = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$live) {
        echo "Live not found.";
        exit;
    }

    // Préparer et exécuter la requête pour récupérer le nombre de clics dans viewer_statistics
    $clickStmt = $conn->prepare("SELECT SUM(clicks) AS total_clicks FROM viewer_statistics WHERE live_id = :id");
    $clickStmt->bindParam(':id', $id, PDO::PARAM_INT);
    $clickStmt->execute();
    $clicksData = $clickStmt->fetch(PDO::FETCH_ASSOC);

    $totalClicks = $clicksData['total_clicks'] ? $clicksData['total_clicks'] : 0; // Si pas de clics, renvoyer 0
} else {
    echo "No live ID provided.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title><?php echo htmlspecialchars($live['title']); ?> - Z Event</title>
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
        <li><a href="/logout/logout.php">Déconnexion</a></li>
    </ul>
</nav>

<section class="live-details">
    <div class="live-image">
        <!-- Appel au script afficher_image.php pour afficher l'image en grand -->
        <img class="image-video" src="afficher_image.php?id=<?php echo $id; ?>" alt="Preview of <?php echo htmlspecialchars($live['title']); ?>" width="100%" height="auto">
    </div>
    <div class="live-info">
        <h1><?php echo htmlspecialchars($live['title']); ?></h1>
        <p><strong>Thématique :</strong> <?php echo htmlspecialchars($live['thematic']); ?></p>
        <p><strong>PEGI Rating :</strong> <?php echo htmlspecialchars($live['pegi_rating']); ?></p>
        <div class="live-description">
            <h2>Description</h2>
            <p><?php echo nl2br(htmlspecialchars($live['description'])); ?></p>
        </div>
        <div class="clicks-info">
            <h2>Nombre de clics</h2>
            <p>Total des clics : <?php echo $totalClicks; ?></p>
        </div>
    </div>
</section>

<footer>
    <p>&copy; 2024 Z Event. Tous droits réservés.</p>
    <div class="footer-links">
        <a href="#" class="footer-link">Conditions d'utilisation</a>
        <a href="#" class="footer-link">Politique de confidentialité</a>
    </div>
</footer>
<script src="script.js"></script>
</body>
</html>

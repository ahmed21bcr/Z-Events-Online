<?php
session_start();
// Vérifier les cookies et le rôle de l'utilisateur
if (!isset($_COOKIE['username']) || $_COOKIE['role'] !== 'admin') {
    echo "Accès interdit. Vous devez être administrateur.";
    header("Location: /login/index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="style.css">
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
        <li><a href="#">Acceuil</a></li>
        <li><a href="/live/index.php">Stream en direct</a></li>
        <li><a href="/fundraised/index.php">Cagnotte</a></li>
        <li><a href="/menu/index.php">Menu Visiteur</a></li>
        <li><a href="/login/index.php">Connexion</a></li>
        <li><a href="/logout/logout.php">Déconnexion</a></li>
    </ul>
</nav>
<div class="admin-dashboard">
        <section class="streamer-management">
            <h2>Gestion des Streamers</h2>
            <button onclick="window.location.href='/create-streamer/index.php'">Créer Compte Streamer</button>
        </section>

        <section class="streamer-management">
            <h2>Gestion Fils D'actualités</h2>
            <button onclick="window.location.href='/news-feed/newsfeed.php'">Créer un article</button>
        </section>

        <section class="equipment-management">
            <h2>Recensement du Matériel</h2>

            <!-- Form to Add Equipment -->
            <form method="post" action="index.php">
                <label for="label">Étiquette du matériel:</label>
                <input type="text" id="label" name="label" required>

                <label for="brand">Marque:</label>
                <input type="text" id="brand" name="brand" required><br><br>

                <input type="submit" value="Ajouter Matériel">
            </form>

            <?php
            include 'db.php';  // Include the database connection

            // Handle form submission
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $label = $_POST['label'];
                $brand = $_POST['brand'];

                // Insert equipment into the database
                $sql = "INSERT INTO equipment (label, brand) VALUES (?, ?)";
                $stmt = $pdo->prepare($sql);
                try {
                    $stmt->execute([$label, $brand]);
                    echo "<p>Matériel ajouté avec succès !</p>";
                } catch (PDOException $e) {
                    echo "<p>Erreur : " . $e->getMessage() . "</p>";
                }
            }

            // Fetch and display equipment
            $sql = "SELECT * FROM equipment";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $equipments = $stmt->fetchAll();

            if ($equipments) {
                echo "<h3>Liste des matériels</h3><ul>";
                foreach ($equipments as $equipment) {
                    echo "<li>ID: " . $equipment['equipment_id'] . " | Étiquette: " . htmlspecialchars($equipment['label']) . " | Marque: " . htmlspecialchars($equipment['brand']) . "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>Aucun matériel trouvé.</p>";
            }
            ?>
        </section>

        <!-- Streamer Count Section -->
        <section class="streamer-count">
            <h2>Nombre de Lives</h2>

            <?php
            // Requête pour compter le nombre de lives dans la table streams
            $sql = "SELECT COUNT(*) AS total_lives FROM streams";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // Affichage du nombre de lives
            $total_lives = $result['total_lives'];
            echo "<p>Nombre total de lives: $total_lives</p>";
            ?>
        </section>
    </div>
</body>

<footer>
    <p>&copy; 2024 Z-Event. Tous droits réservés.</p>
    <div class="footer-links">
        <a href="#" class="footer-link">Conditions d'utilisation</a>
        <a href="#" class="footer-link">Politique de confidentialité</a>
    </div>
</footer>
<script src="script.js"></script>
</html>
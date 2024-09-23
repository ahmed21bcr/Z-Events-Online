<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Create Live Stream</title>
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
    <span class="header-title">Create Live Stream</span>
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

<section class="create-live-section">
    <h2>Create a New Live Stream</h2>
    <form action="submit-live.php" method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <label for="title">Stream Title:</label>
            <input type="text" id="title" name="title" placeholder="Enter stream title" required>
        </div>

        <div class="form-group">
            <label for="thematic">Thematic:</label>
            <input type="text" id="thematic" name="thematic" placeholder="Enter thematic (e.g., Gaming, Music, etc.)" required>
        </div>

        <div class="form-group">
            <label for="pegi">PEGI Rating:</label>
            <select id="pegi" name="pegi">
                <option value="3">PEGI 3</option>
                <option value="7">PEGI 7</option>
                <option value="12">PEGI 12</option>
                <option value="16">PEGI 16</option>
                <option value="18">PEGI 18</option>
            </select>
        </div>

        <div class="form-group">
            <label for="preview">Preview Image:</label>
            <input type="file" id="preview" name="preview" accept="image/*" required>
        </div>

        <div class="form-group">
            <label>Stream Description:</label>
            <textarea id="description" name="description" placeholder="Describe your stream..."></textarea>
        </div>

        <div class="form-group">
            <label for="material">Required Materials:</label>
            <textarea id="material" name="material" placeholder="List any required materials..."></textarea>
        </div>

        <!-- Nouveau champ pour planifier le live -->
        <div class="form-group">
            <label for="start_time">Date et heure de début :</label>
            <input type="datetime-local" id="start_time" name="start_time" required>
        </div>

        <div class="form-group">
            <label for="end_time">Date et heure de fin :</label>
            <input type="datetime-local" id="end_time" name="end_time" required>
        </div>

        <button type="submit" class="submit-btn">Create Stream</button>

    </form>
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

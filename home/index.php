<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Z Event</title>
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

<section class="latest-news">
  <div class="latest-news-wrapper">
    <div class="news-text">
      <h2>Dernières Nouvelles</h2>
      <h1>Le Z Event récolte plus de 10 millions de dollars pour la charité</h1>
      <p>Le marathon caritatif annuel Z Event a dépassé son objectif, récoltant plus de 10 millions de dollars pour diverses organisations caritatives.</p>
      <p class="date">15 avril 2023</p>
      
      <h1>Streamers annoncés pour le Z Event 2023</h1>
      <p>La liste des streamers populaires participant au Z Event de cette année a été révélée, promettant un événement de collecte de fonds excitant et captivant.</p>
      <p class="date">28 mars 2023</p>
    </div>
    <div class="cards-container">
      <div class="card">
        <h1>Streamers en direct</h1>
            <?php
            include 'db.php';
            // Requête pour compter le nombre de lives dans la table `streams`
            $sql = "SELECT COUNT(*) AS total_lives FROM streams";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // Affichage du nombre de lives
            $total_lives = $result['total_lives'];
            echo "<h4>$total_lives</h4>";
            ?>
        <p>Streamers actuellement en direct sur la plateforme Z Event.</p>
      </div>
      <div class="card">
        <h1>Total des fonds récoltés</h1>
        <h4>$8,642,519</h4>
        <p>Le montant total collecté pour la charité jusqu'à présent.</p>
      </div>
    </div>
  </div>
</section>

<section class="about">
  <div class="about-wrapper">
    <div class="about-text">
      <h2>À propos du Z Event</h2>
      <p>Le Z Event est un marathon de collecte de fonds annuel organisé par la communauté de joueurs français. Il réunit des streamers et créateurs de contenu populaires qui utilisent leurs plateformes pour collecter des fonds pour diverses organisations caritatives.</p>
      <p>L'événement est connu pour ses streams en direct captivants, ses défis excitants et l'incroyable générosité de la communauté de joueurs. Au fil des ans, le Z Event a collecté des millions de dollars pour des causes importantes, ayant un impact significatif sur la vie des personnes dans le besoin.</p>
    </div>
    <img src="assets/about-image.png" class="about-img" alt="Image du Z Event" width="20" 
    height="350">
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
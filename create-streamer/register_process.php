<?php
session_start();
require 'db.php';  

// Vérifier si l'utilisateur est admin via les cookies
if (!isset($_COOKIE['username']) || $_COOKIE['role'] !== 'admin') {
    echo "Accès interdit. Seuls les administrateurs peuvent créer des streamers.";
    header("Location: /login/index.php");
    exit();
}

// Gestion du formulaire POST pour créer un compte streamer
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Création de compte streamer...
}
?>

<?php
session_start();
require 'db.php';  // Inclure le fichier de connexion à la base de données

// Vérification si la requête est POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Vérification si le mot de passe et sa confirmation correspondent
    if ($password != $confirm_password) {
        echo "Les mots de passe ne correspondent pas.";
        exit();
    }

    // Vérification si l'utilisateur existe déjà
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "Ce nom d'utilisateur est déjà pris. Veuillez en choisir un autre.";
        exit();
    }

    // Hachage du mot de passe
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insertion de l'utilisateur avec le rôle 'streamer'
    $stmt = $pdo->prepare('INSERT INTO users (username, password, role) VALUES (:username, :password, :role)');
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindValue(':role', 'streamer');  // Le rôle est défini par défaut sur 'streamer'
    
    if ($stmt->execute()) {
        echo "Compte créé avec succès. Bienvenue, " . htmlspecialchars($username) . "!";
        // Rediriger vers une autre page, par exemple une page de connexion
        header("Location: index.php");
    } else {
        echo "Erreur lors de la création du compte.";
    }
}
?>

<?php
session_start();  // Assure-toi que la session est démarrée pour récupérer l'utilisateur connecté
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

// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $title = $_POST['title'];
    $thematic = $_POST['thematic'];
    $pegi = $_POST['pegi'];
    $description = $_POST['description'];
    $material = $_POST['material'];
    $start_time = $_POST['start_time'];  // Date de début
    $end_time = $_POST['end_time'];      // Date de fin

    // Récupérer l'ID du streamer (créateur) à partir de la session
    $created_by = $_SESSION['user_id'];

    // Gestion de l'image de prévisualisation - lire le fichier image en tant que BLOB
    $image = $_FILES['preview']['tmp_name'];
    $imgData = file_get_contents($image);

    // Vérifier si le fichier est une image
    $check = getimagesize($_FILES["preview"]["tmp_name"]);
    if ($check === false) {
        echo "Le fichier n'est pas une image.";
        exit;
    }

    // Insérer les données dans la base de données
    $sql = "INSERT INTO streams (title, thematic, pegi_rating, description, material, preview_image, start_time, end_time, created_by) 
            VALUES (:title, :thematic, :pegi, :description, :material, :preview_image, :start_time, :end_time, :created_by)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':thematic', $thematic);
    $stmt->bindParam(':pegi', $pegi);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':material', $material);
    $stmt->bindParam(':preview_image', $imgData, PDO::PARAM_LOB); // Stockage en tant que BLOB
    $stmt->bindParam(':start_time', $start_time);
    $stmt->bindParam(':end_time', $end_time);
    $stmt->bindParam(':created_by', $created_by); // Ajouter l'ID du streamer

    try {
        $stmt->execute();
        // Obtenir l'ID du live nouvellement créé
        $lastInsertId = $conn->lastInsertId();

        // Rediriger vers la page des détails du live
        header("Location: /live/live.php?id=" . $lastInsertId);
        exit;  // Terminer le script après la redirection
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>

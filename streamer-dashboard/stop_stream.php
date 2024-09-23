<?php
session_start();  // Démarrer la session pour récupérer l'utilisateur connecté

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "z-events";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

// Vérifier si un ID de live est fourni dans l'URL
if (isset($_GET['id'])) {
    $live_id = (int)$_GET['id'];
    $streamer_id = $_SESSION['user_id'];  // L'ID du streamer connecté

    // Vérifier si le streamer est bien le créateur du live
    $stmt = $conn->prepare("SELECT * FROM streams WHERE id = :id AND created_by = :created_by");
    $stmt->bindParam(':id', $live_id, PDO::PARAM_INT);
    $stmt->bindParam(':created_by', $streamer_id, PDO::PARAM_INT);
    $stmt->execute();

    // Si le live existe et que le streamer est le créateur
    if ($stmt->rowCount() > 0) {
        // Supprimer le live
        $deleteStmt = $conn->prepare("DELETE FROM streams WHERE id = :id AND created_by = :created_by");
        $deleteStmt->bindParam(':id', $live_id, PDO::PARAM_INT);
        $deleteStmt->bindParam(':created_by', $streamer_id, PDO::PARAM_INT);

        try {
            $deleteStmt->execute();
            echo "Le live a été supprimé avec succès.";

            // Rediriger vers le tableau de bord du streamer après suppression
            header("Location: streamer_dashboard.php");
            exit;
        } catch (PDOException $e) {
            echo "Erreur lors de la suppression : " . $e->getMessage();
        }
    } else {
        // Si le streamer n'est pas le créateur du live
        echo "Erreur : Vous n'avez pas la permission de supprimer ce live.";
    }
} else {
    echo "Erreur : Aucun ID de live fourni.";
}
?>

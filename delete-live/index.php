<?php
session_start();  // Assure-toi que la session est démarrée
require 'db.php';

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
        } catch (PDOException $e) {
            echo "Erreur lors de la suppression : " . $e->getMessage();
        }
    } else {
        echo "Erreur : Vous n'avez pas la permission de supprimer ce live.";
    }
} else {
    echo "Erreur : Aucun ID de live fourni.";
}
?>

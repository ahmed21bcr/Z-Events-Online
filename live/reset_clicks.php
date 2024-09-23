<?php
// Connexion à la base de données MySQL
// Database connection configuration
$host = 'ixnzh1cxch6rtdrx.cbetxkdyhwsb.us-east-1.rds.amazonaws.com';  // Adjust if necessary
$dbname = 'tjmzqsfikd7skftg';  // Your database name
$username = 'ls4erapz4hg0t1fs';  // Your database username
$password = 'fddb6ge7gda6pzkb';  // Your database password

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

// Vérifier si des données POST ont été envoyées
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $liveId = isset($_POST['live_id']) ? intval($_POST['live_id']) : 0;
    $liveName = isset($_POST['live_name']) ? $_POST['live_name'] : '';

    if ($liveId && $liveName) {
        enregistrerClic($liveId, $liveName);
    }
}

// Fonction pour gérer les clics
function enregistrerClic($liveId, $liveName) {
    global $conn;

    // Vérifier si un enregistrement existe déjà pour ce live
    $sql = "SELECT clicks FROM viewer_statistics WHERE live_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $liveId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Si le live existe déjà, mettre à jour le nombre de clics
        $row = $result->fetch_assoc();
        $newClicks = $row['clicks'] - 1;

        $updateSql = "UPDATE viewer_statistics SET clicks = ?, live_name = ? WHERE live_id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("isi", $newClicks, $liveName, $liveId);
        $updateStmt->execute();
    }
}

// Fermer la connexion
$conn->close();
?>

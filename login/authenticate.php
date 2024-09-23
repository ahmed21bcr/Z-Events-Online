<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare a SQL statement to avoid SQL injection
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Password is correct
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Set cookies with a duration of 7 days
            setcookie('username', $user['username'], time() + (86400 * 7), "/"); // 86400 = 1 day
            setcookie('role', $user['role'], time() + (86400 * 7), "/");

            echo "Login successful. Welcome, " . htmlspecialchars($user['username']) . "!";

            // Redirect based on role
            if ($user['role'] == 'admin') {
                header("Location: /admin-dashboard/index.php");
            } elseif ($user['role'] == 'streamer') {
                header("Location: /streamer-dashboard/index.php");
            }
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "User not found.";
    }
}
?>

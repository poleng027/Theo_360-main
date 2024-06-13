<?php
session_start();
include("classes/database.php");

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_SESSION['username'];
    $feedback = $_POST['feedback'];

    // Database configuration
    $host = '127.0.0.1';
    $db = 'theo360';
    $user = 'root';
    $pass = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insert feedback into the database
        $stmt = $pdo->prepare("INSERT INTO feedback (username, feedback) VALUES (?, ?)");
        $stmt->execute([$username, $feedback]);

        header("Location: feedback-u.php");
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
}
?>

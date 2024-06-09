<?php
include("classes/database.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    $query = $pdo->prepare("DELETE FROM bookings WHERE id = :id");
    $query->execute(['id' => $id]);
}
?>

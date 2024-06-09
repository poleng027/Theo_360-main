<?php
include("classes/database.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $status = $_POST['status'];

    $query = $pdo->prepare("UPDATE bookings SET status = :status WHERE id = :id");
    $query->execute(['status' => $status, 'id' => $id]);
}
?>

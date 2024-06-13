<?php
include("classes/database.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['booking_id'];

    $query = $pdo->prepare("DELETE FROM bookings WHERE booking_id = :booking_id");
    $query->execute(['booking_id' => $id]);
}
?>

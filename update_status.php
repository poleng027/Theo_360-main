<?php
include("classes/database.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['booking_id'];
    $status = $_POST['status'];

    $query = $pdo->prepare("UPDATE bookings SET status = :status WHERE booking_id = :booking_id");
    $query->execute(['status' => $status, 'booking_id' => $id]);
}

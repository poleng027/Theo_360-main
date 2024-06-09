<?php
session_start();
include("classes/database.php");

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

header('Content-Type: application/json');

$year = $_GET['year'];
$month = $_GET['month'];

// Ensure that month is formatted as a two-digit number
$month = str_pad($month, 2, '0', STR_PAD_LEFT);

$query = $pdo->prepare("SELECT date FROM bookings WHERE YEAR(date) = :year AND MONTH(date) = :month AND status = 'Approved'");
$query->execute(['year' => $year, 'month' => $month]);
$bookings = $query->fetchAll(PDO::FETCH_ASSOC);

$bookedDates = array_map(function($booking) {
    return $booking['date'];
}, $bookings);

echo json_encode(['bookedDates' => $bookedDates]);
?>

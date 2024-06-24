<?php
// Database configuration
$host = '127.0.0.1';
$db = 'theo360';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit();
}



class database{


    function opencon(){
        return new PDO('mysql:host=localhost;dbname=theo360','root','');
    }



function exportPayments() {
    $con = $this->opencon();
    $query = "SELECT 
            *
            FROM 
                payments 
            INNER JOIN bookings ON payments.booking_id = bookings.booking_id
            INNER JOIN services ON bookings.service_id = services.service_id
            INNER JOIN users ON bookings.user_id = users.user_id
            WHERE 
                bookings.status = 'finished'";

    $stmt = $con->prepare($query);
    $stmt->execute();

    $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $transactions;
}
}
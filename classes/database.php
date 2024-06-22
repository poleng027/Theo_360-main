<?php
// // Database configuration
$host = '127.0.0.1';
$db = 'theo360';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
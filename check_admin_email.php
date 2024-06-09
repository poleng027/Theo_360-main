<?php
require_once('classes/database.php');

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $con = new database();

    $query = $con->opencon()->prepare("SELECT admin_email FROM user_admin WHERE admin_email = ?");
    $query->execute([$email]);
    $existingUser = $query->fetch();

    if ($existingUser) {
        echo json_encode(['exists' => true]);
    } else {
        echo json_encode(['exists' => false]);
    }
}
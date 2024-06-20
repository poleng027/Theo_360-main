<?php
session_start();

// Function to check if the user is an admin
function isAdmin() {
    // You can replace this with your actual admin check logic
    // For example, checking a user role from the database
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

// If the user is not an admin, show a notification
if (!isAdmin()) {
    echo "<h1>Access Denied</h1>";
    echo "<p>You are not allowed to access the admin page.</p>";
    exit;
}

// If the user is an admin, redirect to the admin page
header('Location: /admin/admin.php');
exit;
?>

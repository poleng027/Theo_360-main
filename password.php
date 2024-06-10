<?php
session_start();
include('classes/database.php'); // Ensure this file correctly sets up the $pdo variable

$username = $_SESSION['username'];
echo "<script type='text/javascript'>console.log('Username: $username');</script>";

// Check if form is submitted for changing password
if (isset($_POST["changepass"])) {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Check if new password matches the confirm password
    if ($newPassword != $confirmPassword) {
        echo "New password and confirm password do not match.";
        exit;
    }

    // Retrieve the user's data from the database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    if ($stmt === false) {
        die("ERROR: Could not prepare query.");
    }

    $stmt->execute([$username]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Verify the current password
        if (password_verify($currentPassword, $result['password'])) {
            // Hash the new password
            $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

            // Update the password in the database
            $updateStmt = $pdo->prepare("UPDATE users SET password = ? WHERE username = ?");
            if ($updateStmt === false) {
                die("ERROR: Could not prepare update query.");
            }

            if ($updateStmt->execute([$newPasswordHash, $username])) {
                echo "Password updated successfully.";
                echo "<script type='text/javascript'>alert('Success');</script>";
            } else {
                echo "Error updating password: " . $pdo->errorInfo()[2];
                echo "<script type='text/javascript'>alert('Error');</script>";
            }
        } else {
            echo "Incorrect current password.";
        }
    } else {
        echo "User not found.";
    }
}

// Check if form is submitted for adding new admin
if (isset($_POST["addnewadmin"])) {
    $newadminusername = $_POST['newadminusername'];
    $newadminpassword = $_POST['newadminpassword'];

    // Check if the username already exists
    $query = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
    $query->execute([':username' => $newadminusername]);
    $count = $query->fetchColumn();

    if ($count > 0) {
        $error = "Username already taken. Please choose another one.";
    } else {
        // Encrypt the password
        $hashedPassword = password_hash($newadminpassword, PASSWORD_DEFAULT);

        // Insert the new user into the database with role as admin
        $query = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, 'admin')");
        $query->execute([':username' => $newadminusername, ':password' => $hashedPassword]);

        $success = "User registered successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Admin Dashboard | Korsat X Parmaga</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="videocam"></ion-icon>
                        </span>
                        <span class="title">Theo 360</span>
                    </a>
                </li>
                <li>
                    <a href="index.php">
                        <span class="icon">
                            <ion-icon name="home"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="reservation.php">
                        <span class="icon">
                            <ion-icon name="calendar"></ion-icon>
                        </span>
                        <span class="title">Reservation</span>
                    </a>
                </li>
                <li>
                    <a href="service.php">
                        <span class="icon">
                            <ion-icon name="card"></ion-icon>
                        </span>
                        <span class="title">Services</span>
                    </a>
                </li>
                <li>
                    <a href="payments.php">
                        <span class="icon">
                            <ion-icon name="mail"></ion-icon>
                        </span>
                        <span class="title">Payments</span>
                    </a>
                </li>
                <li>
                    <a href="password.php">
                        <span class="icon">
                            <ion-icon name="key"></ion-icon>
                        </span>
                        <span class="title">Password</span>
                    </a>
                </li>
                <li>
                    <a href="index.php">
                        <span class="icon">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class="title">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- ========================= Main ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                <div class="search">
                    <label>
                        <input type="text" placeholder="Search here">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div>

                <div class="user">
                    <img src="assets/imgs/customer01.jpg" alt="">
                </div>
            </div>

            <!-- =============== Main Content ================ -->
            <div class="main-content">
                <h2>Password Management</h2>
                <div class="change-password">
                    <h3>Change Password</h3>
                    <form method="post" action="">
                        <input type="password" placeholder="Current Password" name="currentPassword" required>
                        <input type="password" placeholder="New Password" name="newPassword" required>
                        <input type="password" placeholder="Confirm New Password" name="confirmPassword" required>
                        <button type="submit" name="changepass">Change Password</button>
                    </form>
                </div>
                <div class="add-admin">
                    <h3>Add New Admin</h3>
                    <form method="post" action="">
                        <input name="newadminusername" type="text" placeholder="Admin Username" required>
                        <input name="newadminpassword" type="password" placeholder="Admin Password" required>
                        <button name="addnewadmin" type="submit">Add Admin</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- =========== Scripts ========= -->
    <script src="assets/js/main.js"></script>

    <!-- ======= Charts JS ====== -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script src="assets/js/chartsJS.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
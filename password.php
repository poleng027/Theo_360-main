<?php
session_start();
include('classes/database.php'); 

// Check if the user is logged in
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];

// Function to validate password
function validatePassword($password) {
    return preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\W).{8,}$/', $password);
}

// Check if form is submitted for changing password
if (isset($_POST["changepass"])) {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Check if new password matches the confirm password
    if ($newPassword != $confirmPassword) {
        echo "<script type='text/javascript'>document.addEventListener('DOMContentLoaded', function() { 
            var notif = document.createElement('div');
            notif.className = 'notification error';
            notif.innerText = 'New password and confirm password do not match.';
            document.body.appendChild(notif);
            setTimeout(function() {
                notif.style.display = 'none';
            }, 5000);
        });</script>";
    } else if (!validatePassword($newPassword)) {
        // Check if the new password meets the criteria
        echo "<script type='text/javascript'>document.addEventListener('DOMContentLoaded', function() { 
            var notif = document.createElement('div');
            notif.className = 'notification error';
            notif.innerText = 'Password must be at least 8 characters long, include an uppercase letter, a lowercase letter, and a special character.';
            document.body.appendChild(notif);
            setTimeout(function() {
                notif.style.display = 'none';
            }, 5000);
        });</script>";
    } else {
        // Retrieve the user's data from the database
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        if ($stmt === false) {
            die("<script type='text/javascript'>alert('ERROR: Could not prepare query.');</script>");
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
                    die("<script type='text/javascript'>alert('ERROR: Could not prepare update query.');</script>");
                }

                if ($updateStmt->execute([$newPasswordHash, $username])) {
                    echo "<script type='text/javascript'>document.addEventListener('DOMContentLoaded', function() { 
                        var notif = document.createElement('div');
                        notif.className = 'notification success';
                        notif.innerText = 'Password updated successfully.';
                        document.body.appendChild(notif);
                        setTimeout(function() {
                            notif.style.display = 'none';
                        }, 5000);
                    });</script>";
                } else {
                    echo "<script type='text/javascript'>document.addEventListener('DOMContentLoaded', function() { 
                        var notif = document.createElement('div');
                        notif.className = 'notification error';
                        notif.innerText = 'Error updating password: " . $pdo->errorInfo()[2] . "';
                        document.body.appendChild(notif);
                        setTimeout(function() {
                            notif.style.display = 'none';
                        }, 5000);
                    });</script>";
                }
            } else {
                echo "<script type='text/javascript'>document.addEventListener('DOMContentLoaded', function() { 
                    var notif = document.createElement('div');
                    notif.className = 'notification error';
                    notif.innerText = 'Incorrect current password.';
                    document.body.appendChild(notif);
                    setTimeout(function() {
                        notif.style.display = 'none';
                    }, 5000);
                });</script>";
            }
        } else {
            echo "<script type='text/javascript'>document.addEventListener('DOMContentLoaded', function() { 
                var notif = document.createElement('div');
                notif.className = 'notification error';
                notif.innerText = 'User not found.';
                document.body.appendChild(notif);
                setTimeout(function() {
                    notif.style.display = 'none';
                }, 5000);
            });</script>";
        }
    }
}

// Check if form is submitted for adding new admin
if (isset($_POST["addnewadmin"])) {
    $newadminusername = $_POST['newadminusername'];
    $newadminpassword = $_POST['newadminpassword'];

    // Check if the password meets the criteria
    if (!validatePassword($newadminpassword)) {
        echo "<script type='text/javascript'>document.addEventListener('DOMContentLoaded', function() { 
            var notif = document.createElement('div');
            notif.className = 'notification error';
            notif.innerText = 'Password must be at least 8 characters long, include an uppercase letter, a lowercase letter, and a special character.';
            document.body.appendChild(notif);
            setTimeout(function() {
                notif.style.display = 'none';
            }, 5000);
        });</script>";
    } else {
        // Check if the username already exists
        $query = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
        $query->execute([':username' => $newadminusername]);
        $count = $query->fetchColumn();

        if ($count > 0) {
            $error = "Username already taken. Please choose another one.";
            echo "<script type='text/javascript'>document.addEventListener('DOMContentLoaded', function() { 
                var notif = document.createElement('div');
                notif.className = 'notification error';
                notif.innerText = '$error';
                document.body.appendChild(notif);
                setTimeout(function() {
                    notif.style.display = 'none';
                }, 5000);
            });</script>";
        } else {
            // Encrypt the password
            $hashedPassword = password_hash($newadminpassword, PASSWORD_DEFAULT);

            // Insert the new user into the database with role as admin
            $query = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, 'admin')");
            if ($query->execute([':username' => $newadminusername, ':password' => $hashedPassword])) {
                $success = "User registered successfully!";
                echo "<script type='text/javascript'>document.addEventListener('DOMContentLoaded', function() { 
                    var notif = document.createElement('div');
                    notif.className = 'notification success';
                    notif.innerText = '$success';
                    document.body.appendChild(notif);
                    setTimeout(function() {
                        notif.style.display = 'none';
                    }, 5000);
                });</script>";
            } else {
                $error = "Error registering user: " . $pdo->errorInfo()[2];
                echo "<script type='text/javascript'>document.addEventListener('DOMContentLoaded', function() { 
                    var notif = document.createElement('div');
                    notif.className = 'notification error';
                    notif.innerText = '$error';
                    document.body.appendChild(notif);
                    setTimeout(function() {
                        notif.style.display = 'none';
                    }, 5000);
                });</script>";
            }
        }
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
    <style>
        .change-password,
        .add-admin {
        margin-bottom: 20px;
        }
        
        .change-password h3,
        .add-admin h3 {
        margin-top: 0;
        color: white;
        }
        
        .change-password form,
        .add-admin form {
        margin-top: 10px;
        }
        
        .change-password input,
        .add-admin input,
        .change-password button,
        .add-admin button {
        display: block;
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
        }
        
        .change-password button,
        .add-admin button {
        background-color: var(--blue);
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        }
        
        .change-password button:hover,
        .add-admin button:hover {
        background-color: var(--purple);
        }
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #444;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
        .notification.success {
            background-color: #4CAF50;
        }
        .notification.error {
            background-color: #f44336;
        }
    </style>
</head>
<body>

<?php include("sidebar.php");?>   

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

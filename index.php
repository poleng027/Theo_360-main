<?php
include("classes/database.php");

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $query->execute(['username' => $username]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            // Store user info in session
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $user['role']; 

            // Redirect based on user role
            if ($user['role'] == 'admin' || $user['role'] == 's-admin') {
                header("Location: admin.php");
                exit();
            } else {
                header("Location: landing-page-u.php");
                exit();
            }
        } else {
            $errorMessage = "Invalid password!";
        }
    } else {
        $errorMessage = "User not found!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <style>
        /* Style similar to the signup page */
        body {
            font-family: Arial, sans-serif;
            background-image: url('./assets/imgs/background.png');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: white;
        }

        .login-container {
            background-color: rgba(58, 29, 97, 0.9); 
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.5);
            width: 400px;
            text-align: center;
        }

        .login-container h1 {
            margin-bottom: 30px;
            color: white;
        }

        .input-container {
            margin-bottom: 20px;
            text-align: left;
            margin-right: 20px;
        }

        .input-container label {
            display: block;
            margin-bottom: 8px;
            color: white;
            font-weight: bold;
        }

        .input-container input {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #ddd;
            font-size: 16px;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .input-container input::placeholder {
            color: #ccc;
        }

        button {
            width: 102%;
            padding: 12px;
            background-color: #6a0dad;
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #5a0ca0;
        }

        .signup-link {
            display: block;
            margin-top: 20px;
            color: #ccc;
            text-decoration: none;
            font-size: 14px;
        }

        .signup-link:hover {
            text-decoration: underline;
        }

        .error {
            background-color: #f44336;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
        }

        .error a {
            color: white;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
        <form method="post">
            <?php if (isset($errorMessage)): ?>
                <div class="error"><?= $errorMessage ?></div>
            <?php endif; ?>
            <div class="input-container">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-container">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
            <p>Don't have an account? <a href="signup.php" class="signup-link">Sign up</a></p>
        </form>
    </div>
</body>
</html>

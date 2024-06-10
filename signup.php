<?php
include("classes/database.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $firstname = $_POST['first_name'];
    $lastname = $_POST['last_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $phonenum = $_POST['pnum'];

    // Check if the username already exists
    $query = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
    $query->execute(['username' => $username]);
    $count = $query->fetchColumn();

    if ($count > 0) {
        $error = "Username already taken. Please choose another one.";
    } else {
        // Encrypt the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new user into the database
        $query = $pdo->prepare("INSERT INTO users (email, first_name, last_name, username, password, p_num) VALUES (:email, :first_name, :last_name, :username, :password, :p_num)");
        $query->execute(['email' => $email, 'first_name' => $firstname, 'last_name' => $lastname, 'username' => $username, 'password' => $hashedPassword, 'p_num' => $phonenum]);

        $success = "User registered successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        /* Style similar to the login page */
        body {
            font-family: Arial, sans-serif;
            background-image: url('./assets/imgs/bg.png'); /* Replace with your background image */
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: white;
        }

        .signup-container {
            background-color: rgba(41, 34, 48, 0.9); /* Semi-transparent dark purple */
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.5);
            width: 400px;
            text-align: center;
        }

        .signup-container h1 {
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

        .back-button {
            margin-top: 20px;
            width: 96%;
            padding: 12px;
            background-color: #ccc;
            border: none;
            border-radius: 10px;
            color: black;
            font-size: 18px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .back-button:hover {
            background-color: #bbb;
        }

        .error {
            color: red;
            margin-bottom: 20px;
        }

        .success {
            color: green;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <h1>Sign Up</h1>
        <?php if (isset($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="success"><?= $success ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="input-container">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-container">
                <label for="first_name">First Name:</label>
                <input type="first_name" id="first_name" name="first_name" required>
            </div>
            <div class="input-container">
                <label for="last_name">Last Name:</label>
                <input type="last_name" id="last_name" name="last_name" required>
            </div>
            <div class="input-container">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-container">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-container">
                <label for="pnum">Phone Number:</label>
                <input type="pnum" id="pnum" name="pnum" required>
            </div>
            <button type="submit">Sign Up</button>
        </form>
        <a href="index.php" class="back-button">Back to Login</a>
    </div>
</body>
</html>

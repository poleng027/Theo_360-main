<?php
// Include the database configuration file
require_once './classes/database.php';

// Check if form is submitted and all fields are set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'], $_POST['first_name'], $_POST['last_name'], $_POST['username'], $_POST['password'], $_POST['confirmPassword'], $_POST['pnum'])) {

    // Sanitize and validate input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $first_name = filter_var($_POST['first_name'], FILTER_SANITIZE_STRING);
    $last_name = filter_var($_POST['last_name'], FILTER_SANITIZE_STRING);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $pnum = filter_var($_POST['pnum'], FILTER_SANITIZE_STRING);

    // Server-side validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit();
    }
    if ($password !== $confirmPassword) {
        echo "Passwords do not match";
        exit();
    }
    if (!preg_match('/^\d{11}$/', $pnum)) {
        echo "Phone number must be 11 digits";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert into database using PDO
    $sql = "INSERT INTO users (email, first_name, last_name, username, password, p_num, role) 
            VALUES (:email, :first_name, :last_name, :username, :password, :p_num, 'user')";

    $stmt = $pdo->prepare($sql);
    $params = [
        ':email' => $email,
        ':first_name' => $first_name,
        ':last_name' => $last_name,
        ':username' => $username,
        ':password' => $hashed_password,
        ':p_num' => $pnum,
    ];

    // Execute the prepared statement
    $stmt->execute($params);

    // Check if insertion was successful
    if ($stmt->rowCount() > 0) {
        $success = "User registered successfully";
    } else {
        $message = "Failed to register user";
    }
    $message = "An error occurred while processing your request";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
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
            margin-top: 20%;
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="signup-container">
        <h1>Sign Up</h1>
        <div id="message"></div>
        <form id="signup-form" action="signup.php" method="POST">
            <div class="input-container">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <div id="email-status"></div>
            </div>
            <div class="input-container">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" required>
            </div>
            <div class="input-container">
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" required>
            </div>
            <div class="input-container">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <div id="username-status"></div>
            </div>
            <div class="input-container">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <div id="password-status"></div>
            </div>
            <div class="input-container">
                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>
                <div id="confirm-password-status"></div>
            </div>
            <div class="input-container">
                <label for="pnum">Phone Number:</label>
                <input type="text" id="pnum" name="pnum" required>
                <div id="phone-status"></div>
            </div>
            <button type="submit" id="submitBtn">Sign Up</button>
            <input type="hidden" name="token" value="<?php echo $token; ?>">
        </form>
        <a href="index.php" class="back-button">Back to Login</a>
    </div>
    <script>
            $(document).ready(function() {
            $('#submitBtn').prop('disabled', true);

            // Function to validate individual input fields
            function validateInput(input) {
                switch (input.name) {
                    case 'email':
                        return validateEmail(input);
                    case 'username':
                        return validateUsername(input);
                    case 'password':
                        return validatePassword(input);
                    case 'confirmPassword':
                        return validateConfirmPassword(input);
                    case 'pnum':
                        return validatePhoneNumber(input);
                    default:
                        if (input.checkValidity()) {
                            input.classList.remove("is-invalid");
                            input.classList.add("is-valid");
                            return true;
                        } else {
                            input.classList.remove("is-valid");
                            input.classList.add("is-invalid");
                            return false;
                        }
                }
            }

            // Function to validate email format
            function validateEmail(emailInput) {
                const email = emailInput.value;
                const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (regex.test(email)) {
                    emailInput.classList.remove("is-invalid");
                    emailInput.classList.add("is-valid");
                    $('#email-status').text('').css('color', 'green');
                    return true;
                } else {
                    emailInput.classList.remove("is-valid");
                    emailInput.classList.add("is-invalid");
                    $('#email-status').text('Invalid email format').css('color', 'red');
                    return false;
                }
            }

            // Function to validate username
            function validateUsername(usernameInput) {
                const username = usernameInput.value;
                const usernameStatus = $('#username-status');

                if (username.length > 0) {
                    // Simulated asynchronous check (replace with actual logic)
                    // This example assumes check is successful
                    setTimeout(function() {
                        usernameInput.classList.remove("is-invalid");
                        usernameInput.classList.add("is-valid");
                        usernameStatus.text('Username available').css('color', 'green');
                    }, 1000); // Simulate delay
                    return true;
                } else {
                    usernameInput.classList.remove("is-valid");
                    usernameInput.classList.add("is-invalid");
                    usernameStatus.text('').css('color', 'red');
                    return false;
                }
            }

            // Function to validate password strength
            function validatePassword(passwordInput) {
                const password = passwordInput.value;
                const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

                if (regex.test(password)) {
                    passwordInput.classList.remove("is-invalid");
                    passwordInput.classList.add("is-valid");
                    $('#password-status').text('Password is strong').css('color', 'green');
                    return true;
                } else {
                    passwordInput.classList.remove("is-valid");
                    passwordInput.classList.add("is-invalid");
                    $('#password-status').text('Password must be at least 8 characters long and include an uppercase letter, a lowercase letter, a number, and a special character.').css('color', 'red');
                    return false;
                }
            }

            // Function to validate password confirmation
            function validateConfirmPassword(confirmPasswordInput) {
                const passwordInput = document.querySelector("input[name='password']");
                const password = passwordInput.value;
                const confirmPassword = confirmPasswordInput.value;

                if (password === confirmPassword && password !== '') {
                    confirmPasswordInput.classList.remove("is-invalid");
                    confirmPasswordInput.classList.add("is-valid");
                    $('#confirm-password-status').text('Passwords match').css('color', 'green');
                    return true;
                } else {
                    confirmPasswordInput.classList.remove("is-valid");
                    confirmPasswordInput.classList.add("is-invalid");
                    $('#confirm-password-status').text('Passwords do not match').css('color', 'red');
                    return false;
                }
            }

            // Function to validate phone number format
            function validatePhoneNumber(phoneInput) {
                const phoneNumber = phoneInput.value;
                const regex = /^\d{11}$/;

                if (regex.test(phoneNumber)) {
                    phoneInput.classList.remove("is-invalid");
                    phoneInput.classList.add("is-valid");
                    $('#phone-status').text('Valid phone number').css('color', 'green');
                    return true;
                } else {
                    phoneInput.classList.remove("is-valid");
                    phoneInput.classList.add("is-invalid");
                    $('#phone-status').text('Invalid phone number').css('color', 'red');
                    return false;
                }
            }

            // Function to validate the entire form
            function validateForm() {
                const inputs = document.querySelectorAll('#signup-form input');
                let isValid = true;

                inputs.forEach(input => {
                    if (!validateInput(input)) {
                        isValid = false;
                    }
                });

                $('#submitBtn').prop('disabled', !isValid);
            }

            // Event listener for input changes
            $('#signup-form input').on('input', function() {
                validateInput(this);
                validateForm();
            });

            // Initial form validation
            validateForm();
        });
    </script>
</body>
</html>
<?php
session_start();
include("classes/database.php");

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$username = $_SESSION['username'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = $_POST['location'];
    $indoor_outdoor = $_POST['indoor-outdoor'];
    $event_title = $_POST['event-title'];
    $package = $_POST['package'];
    $payment_method = $_POST['payment-method'];
    $requests = $_POST['requests'];

    // Check if the date is already booked
    $query = $pdo->prepare("SELECT COUNT(*) FROM bookings WHERE date = :date");
    $query->execute(['date' => $date]);
    $count = $query->fetchColumn();

    if ($count > 0) {
        $warning = "The selected date is already booked. Please choose another date.";
    } else {
        $query = $pdo->prepare("INSERT INTO bookings (username, firstname, lastname, email, phone, date, time, location, indoor_outdoor, event_title, package, payment_method, requests) VALUES (:username, :firstname, :lastname, :email, :phone, :date, :time, :location, :indoor_outdoor, :event_title, :package, :payment_method, :requests)");
        $query->execute([
            'username' => $username,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'phone' => $phone,
            'date' => $date,
            'time' => $time,
            'location' => $location,
            'indoor_outdoor' => $indoor_outdoor,
            'event_title' => $event_title,
            'package' => $package,
            'payment_method' => $payment_method,
            'requests' => $requests
        ]);

        $success = "Booking submitted successfully!";
    }
}

$services = $pdo->query("SELECT * FROM services")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Now</title>
    <style>
    body {
        margin: 0;
        padding: 20px;
        font-family: 'Arial', sans-serif;
        background-color: #b897b0;
        background: url(./assets/imgs/bg.png);
        background-size: cover;
        background-position: center;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
    
    .container {
        padding: 30px;
        border-radius: 50px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        max-width: 600px;
        width: 90%;
        background: url(bg.png), rgba(58, 29, 97, 0.9);
        background-blend-mode: overlay;
        background-size: cover;
        background-position: center;
        color: #ded5d5;
        animation: fadeIn 2s ease-in-out;
        overflow-y: auto;
        max-height: 90vh;
        border: 3px solid rgba(58, 29, 97, 0.9);
    }
    
    h1 {
        font-size: 2.5em;
        color: #b596cb; /* Purple color */
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5), 0 0 5px #ded5d5; /* Text shadow */
        margin-bottom: 50px;
        text-align: center;
    }
    
    form {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
    }
    
    .form-row {
        display: flex;
        justify-content: space-between; /* Space between for better alignment */
        width: 100%;
        gap: 100px;
        margin-bottom: 20px;
    }
    
    .form-group {
        flex: 1;
        text-align: left;
        margin-bottom: 20px;
    }
    
    label {
        display: block;
        font-size: 1.2em;
        margin-bottom: 5px;
        color: #ded5d5; /* Ensure labels are visible */
        text-align: center;
    }
    
    input, textarea, select {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ddd;
        font-size: 1em;
        margin-top: 5px;
        background-color: #eee; /* Light background color for inputs */
    }
    
    textarea {
        resize: vertical;
    }
    
    button {
        margin-top: 20px;
        padding: 10px 20px;
        font-size: 1em;
        color: white;
        background-color: #6a0dad;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    
    button:hover {
        background-color: #a52997;
    }
    
    .notification {
        margin-top: 20px;
        font-size: 1.1em;
        text-align: center;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
    </style>
</head>
<body>
    <?php include("navbar-u.php"); ?>

    <div class="container">
        <h1>Book Now</h1>
        <?php
        if (isset($warning)) {
            echo "<p class='notification' style='color: red;'>$warning</p>";
        } elseif (isset($success)) {
            echo "<p class='notification' style='color: green;'>$success</p>";
        }
        ?>
        <form method="post">
            <div class="form-row-center">
                <div class="form-group">
                    <label for="firstname">First Name:</label>
                    <input type="text" id="firstname" name="firstname" required>
                </div>
                <div class="form-group">
                    <label for="lastname">Last Name:</label>
                    <input type="text" id="lastname" name="lastname" required>
                </div>
            </div>
            <div class="form-row-center">
                <div class="form-group">
                    <label for="email">Email Address:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number:</label>
                    <input type="tel" id="phone" name="phone" required>
                </div>
            </div>
            <div class="form-row-center">
                <div class="form-group">
                    <label for="date">Date of Booking:</label>
                    <input type="date" id="date" name="date" required>
                </div>
            </div>
            <div class="form-row-center">
                <div class="form-group">
                    <label for="time">Time of Booking:</label>
                    <input type="time" id="time" name="time" required>
                </div>
            </div>
            <div class="form-row-center">
                <div class="form-group">
                    <label for="location">Location (Full Address):</label>
                    <input type="text" id="location" name="location" required>
                </div>
                <div class="form-group">
                    <label for="indoor-outdoor">Indoor or Outdoor?:</label>
                    <select id="indoor-outdoor" name="indoor-outdoor" required>
                        <option value="" disabled selected>Select an option</option>
                        <option value="indoor">Indoor</option>
                        <option value="outdoor">Outdoor</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="event-title">Title of the Event:</label>
                <input type="text" id="event-title" name="event-title" required>
            </div>
            <div class="form-group">
                <label for="package">Package:</label>
                <select id="package" name="package" required>
                    <option value="" disabled selected>Select a package</option>
                    <?php foreach($services as $service) { ?>
                        <option value="<?php echo htmlspecialchars($service['service_name'] . ' - PHP ' . $service['service_price']); ?>">
                            <?php echo htmlspecialchars($service['service_name'] . ' - PHP ' . $service['service_price']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="payment-method">Payment method:</label>
                <select id="payment-method" name="payment-method" required>
                    <option value="cash">Cash</option>
                    <option value="paycheque">Paycheque</option>
                    <option value="direct deposit">Direct Deposit</option>
                    <option value="pay cards">Pay Cards</option>
                    <option value="mobile wallets">Mobile Wallets</option>
                </select>
            </div>
            <div class="form-group">
                <label for="requests">Additional Requests:</label>
                <textarea id="requests" name="requests" rows="4"></textarea>
            </div>
            <button type="submit">Submit</button>
        </form>
        <p class="notification">If your reservation goes through successfully, you will be notified.</p>
    </div>
</body>
</html>


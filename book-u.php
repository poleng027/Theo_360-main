<?php
session_start();
include("classes/database.php");

// Check if the user is logged in
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];

// Ensure you have a valid database connection
if ($pdo) {
    $userQuery = $pdo->prepare("SELECT user_id FROM users WHERE username = :username");
    $userQuery->execute(['username' => $username]);
    $user = $userQuery->fetch(PDO::FETCH_ASSOC);

    // Check if the user exists and has a valid user_id
    if (!$user || !isset($user['user_id'])) {
        header("Location: index.php");
        exit;
    }

    $user_id = $user['user_id'];
} else {
    die('Database connection failed');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = $_POST['location'];
    $indoor_outdoor = $_POST['indoor-outdoor'];
    $event_title = $_POST['event-title'];
    $service_id = $_POST['service-id'];
    $payment_method = $_POST['payment-method'];
    $requests = $_POST['requests'];

    // Check if the selected date is in the past
    if (strtotime($date) < strtotime('today')) {
        $warning = "You can't book events for past dates. Please choose a future date.";
    } else {
        // Check if the date is already booked
        $query = $pdo->prepare("SELECT COUNT(*) FROM bookings WHERE date = :date AND time = :time");
        $query->execute(['date' => $date, 'time' => $time]);
        $count = $query->fetchColumn();

        if ($count > 0) {
            $warning = "The selected date and time is already booked. Please choose another date or time.";
        } else {
            // Insert booking
            $query = $pdo->prepare("INSERT INTO bookings (user_id, service_id, date, time, location, indoor_outdoor, event_title, status) VALUES (:user_id, :service_id, :date, :time, :location, :indoor_outdoor, :event_title, 'pending')");
            $query->execute([
                'user_id' => $user_id,
                'service_id' => $service_id,
                'date' => $date,
                'time' => $time,
                'location' => $location,
                'indoor_outdoor' => $indoor_outdoor,
                'event_title' => $event_title
            ]);
            $booking_id = $pdo->lastInsertId();

            // Insert payment
            $query = $pdo->prepare("INSERT INTO payments (booking_id, payment_method, payment_status) VALUES (:booking_id, :payment_method, 'pending')");
            $query->execute([
                'booking_id' => $booking_id,
                'payment_method' => $payment_method
            ]);

            // Insert request
            if (!empty($requests)) {
                $query = $pdo->prepare("INSERT INTO requests (booking_id, request_desc) VALUES (:booking_id, :request_desc)");
                $query->execute([
                    'booking_id' => $booking_id,
                    'request_desc' => $requests
                ]);
            }
            $success = "Booking submitted successfully!";
        }
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
        padding: 150px;
        font-family: 'Arial', sans-serif;
        background-color: #b897b0;
        background: url(./assets/imgs/bg.png) no-repeat center center fixed;
        background-size: cover;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
    .container {
        background: rgba(255, 255, 255, 0.8);
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 500px;
        width: 100%;
    }
    h1 {
        font-size: 2em;
        margin-bottom: 20px;
        text-align: center;
    }
    form {
        display: flex;
        flex-direction: column;
    }
    label {
        margin: 10px 0 5px;
        font-weight: bold;
    }
    input, select, textarea {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        width: 100%;
        margin-bottom: 20px;
        box-sizing: border-box;
    }
    button {
        padding: 10px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 1em;
    }
    button:hover {
        background-color: #45a049;
    }
    .message {
        margin-bottom: 20px;
        padding: 10px;
        border-radius: 4px;
    }
    .warning {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    .success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
</style>
</head>
<body>
<?php include("navbar-u.php");?>  
<div class="container">
<h1>Book a Service</h1>
<?php if (isset($warning)): ?>
<p class="message warning"><?php echo $warning; ?></p>
<?php endif; ?>
<?php if (isset($success)): ?>
<p class="message success"><?php echo $success; ?></p>
<?php endif; ?>
<form method="post">
    <label for="service-id">Service:</label>
    <select name="service-id" id="service-id">
        <?php foreach ($services as $service): ?>
            <option value="<?php echo $service['service_id']; ?>"><?php echo htmlspecialchars($service['service_name']); ?></option>
        <?php endforeach; ?>
    </select>
    <label for="date">Date:</label>
    <input type="date" name="date" id="date" required>
    <label for="time">Time:</label>
    <input type="time" name="time" id="time" required>
    <label for="location">Location:</label>
    <input type="text" name="location" id="location" required>
    <div class="form-group">
        <label for="indoor-outdoor">Indoor or Outdoor?:</label>
        <select id="indoor-outdoor" name="indoor-outdoor" required>
            <option value="indoor">Indoor</option>
            <option value="outdoor">Outdoor</option>
        </select>
    </div>
    <label for="event-title">Event Title/ Theme:</label>
    <input type="text" name="event-title" id="event-title" required>
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
    <label for="requests">Special Requests:</label>
    <textarea name="requests" id="requests"></textarea>
    <button type="submit">Submit</button>
</form>
</div>
</body>
</html>

<?php
session_start();
include("classes/database.php");
if (!isset($_SESSION['username'])) {
   header("Location: index.php");
   exit;
}
$username = $_SESSION['username'];
// Ensure you have a valid database connection
if ($pdo) {
   $userQuery = $pdo->prepare("SELECT user_id FROM users WHERE username = :username");
   $userQuery->execute(['username' => $username]);
   $user = $userQuery->fetch(PDO::FETCH_ASSOC);
   if (!$user) {
       die('User not found');
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
</style>
</head>
<body>
<div>
<h1>Book a Service</h1>
<?php if (isset($warning)): ?>
<p style="color: red;"><?php echo $warning; ?></p>
<?php endif; ?>
<?php if (isset($success)): ?>
<p style="color: green;"><?php echo $success; ?></p>
<?php endif; ?>
<form method="post">
<label for="service-id">Service:</label>
<select name="service-id" id="service-id">
<?php foreach ($services as $service): ?>
<option value="<?php echo $service['service_id']; ?>"><?php echo htmlspecialchars($service['service_name']); ?></option>
<?php endforeach; ?>
</select><br>
<label for="date">Date:</label>
<input type="date" name="date" id="date" required><br>
<label for="time">Time:</label>
<input type="time" name="time" id="time" required><br>
<label for="location">Location:</label>
<input type="text" name="location" id="location" required><br>
<label for="indoor-outdoor">Indoor/Outdoor:</label>
<input type="text" name="indoor-outdoor" id="indoor-outdoor" required><br>
<label for="event-title">Event Title:</label>
<input type="text" name="event-title" id="event-title" required><br>
<label for="payment-method">Payment Method:</label>
<input type="text" name="payment-method" id="payment-method" required><br>
<label for="requests">Special Requests:</label>
<textarea name="requests" id="requests"></textarea><br>
<button type="submit">Submit</button>
</form>
</div>
</body>
</html>
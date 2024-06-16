<?php
include 'classes/database.php'; // Database connection file
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}


// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $bookingId = $_POST['booking_id'];
        $deleteQuery = "DELETE FROM bookings WHERE booking_id = :booking_id";
        $stmt = $pdo->prepare($deleteQuery);
        $stmt->execute(['booking_id' => $bookingId]);
    }

    if (isset($_POST['save'])) {
        $bookingId = $_POST['booking_id'];
        $status = $_POST['status'];
        $updateBookingQuery = "UPDATE bookings SET status = :status WHERE booking_id = :booking_id";
        $stmt = $pdo->prepare($updateBookingQuery);
        $stmt->execute(['status' => $status, 'booking_id' => $bookingId]);

        $paymentStatus = $status === 'finished' ? 'finished' : 'pending';
        $updatePaymentQuery = "UPDATE payments SET payment_status = :payment_status WHERE booking_id = :booking_id";
        $stmt = $pdo->prepare($updatePaymentQuery);
        $stmt->execute(['payment_status' => $paymentStatus, 'booking_id' => $bookingId]);
    }

    // Redirect to avoid resubmission
    header("Location: payments.php");
    exit();
}

try {
    // Fetch finished bookings
    $finishedQuery = "
        SELECT b.booking_id, u.first_name, u.last_name, s.service_name, p.payment_method, p.payment_status
        FROM bookings b
        JOIN users u ON b.user_id = u.user_id
        JOIN services s ON b.service_id = s.service_id
        JOIN payments p ON b.booking_id = p.booking_id
        WHERE p.payment_status = 'finished'
    ";
    $finishedStmt = $pdo->prepare($finishedQuery);
    $finishedStmt->execute();
    $finishedBookings = $finishedStmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch pending bookings
    $pendingQuery = "
        SELECT b.booking_id, u.first_name, u.last_name, s.service_name, p.payment_method, p.payment_status
        FROM bookings b
        JOIN users u ON b.user_id = u.user_id
        JOIN services s ON b.service_id = s.service_id
        JOIN payments p ON b.booking_id = p.booking_id
        WHERE p.payment_status = 'pending'
    ";
    $pendingStmt = $pdo->prepare($pendingQuery);
    $pendingStmt->execute();
    $pendingBookings = $pendingStmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch total payment for finished bookings
    $totalFinishedQuery = "
        SELECT SUM(s.service_price) AS total_payment 
        FROM bookings b
        JOIN services s ON b.service_id = s.service_id
        JOIN payments p ON b.booking_id = p.booking_id
        WHERE p.payment_status = 'finished'
    ";
    $totalFinishedStmt = $pdo->prepare($totalFinishedQuery);
    $totalFinishedStmt->execute();
    $totalFinishedRow = $totalFinishedStmt->fetch(PDO::FETCH_ASSOC);
    $totalFinishedPayment = $totalFinishedRow['total_payment'] ?? 0; // Default to 0 if no payment found

} catch (PDOException $e) {
    // Handle any PDO exceptions here
    echo "Error: " . $e->getMessage();
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="./assets/css/style.css?v=<?php echo time();?>">
    <style>
        /* Modern and professional table design */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 18px;
            text-align: left;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        table thead tr {
            background-color: #69185B;
            color: #ffffff;
        }

        table th,
        table td {
            padding: 12px 15px;
            border: 1px solid #dddddd;
        }

        table tbody tr {
            border-bottom: 1px solid #dddddd;
        }

        table tbody tr:last-of-type {
            border-bottom: 2px solid #007bff;
        }

        h3 {
            color: #fff;
            margin-top: 20px;
        }
        
    </style>
</head>
<body>
    
<?php include("sidebar.php");?>   

            <!-- =============== Main Content ================ -->
            <div class="main-content">
                <h2>Pending Payments</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Pending Payment</th>
                            <th>Payment Method</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pendingBookings)) : ?>
                            <?php foreach ($pendingBookings as $booking): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($booking['first_name'] . ' ' . $booking['last_name']); ?></td>
                                    <td><?php echo htmlspecialchars($booking['service_name']); ?></td>
                                    <td><?php echo htmlspecialchars($booking['payment_method']); ?></td>
                                    <td>
                                        <form method="post" action="payments.php" style="display:inline;">
                                            <input type="hidden" name="booking_id" value="<?php echo htmlspecialchars($booking['booking_id']); ?>">
                                            <select name="status">
                                                <option value="pending" <?php echo $booking['payment_status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                                <option value="finished" <?php echo $booking['payment_status'] === 'finished' ? 'selected' : ''; ?>>Finished</option>
                                            </select>
                                            <button type="submit" name="save">Save</button>
                                        </form>
                                        <form method="post" action="payments.php" style="display:inline;">
                                            <input type="hidden" name="booking_id" value="<?php echo htmlspecialchars($booking['booking_id']); ?>">
                                            <button type="submit" name="delete">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">No pending payments found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <h2>Finished Payments</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Finished Payment</th>
                            <th>Payment Method</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($finishedBookings)) : ?>
                            <?php foreach ($finishedBookings as $booking): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($booking['first_name'] . ' ' . $booking['last_name']); ?></td>
                                    <td><?php echo htmlspecialchars($booking['service_name']); ?></td>
                                    <td><?php echo htmlspecialchars($booking['payment_method']); ?></td>
                                    <td>
                                        <form method="post" action="payments.php" style="display:inline;">
                                            <input type="hidden" name="booking_id" value="<?php echo htmlspecialchars($booking['booking_id']); ?>">
                                            <select name="status">
                                                <option value="pending" <?php echo $booking['payment_status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                                <option value="finished" <?php echo $booking['payment_status'] === 'finished' ? 'selected' : ''; ?>>Finished</option>
                                            </select>
                                            <button type="submit" name="save">Save</button>
                                        </form>
                                        <form method="post" action="payments.php" style="display:inline;">
                                            <input type="hidden" name="booking_id" value="<?php echo htmlspecialchars($booking['booking_id']); ?>">
                                            <button type="submit" name="delete">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">No finished payments found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <h3>Total Payment: PHP <?php echo number_format($totalFinishedPayment, 2); ?></h3>
            </div>
        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="assets/js/main.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>

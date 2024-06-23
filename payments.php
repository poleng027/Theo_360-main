<?php
include 'classes/database.php'; // Database connection file
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php"); // Redirect to login page if not logged in
    exit();
}

// Check if the user is an admin or s-admin
if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 's-admin') {
    header("Location: denied.php"); // Redirect to denied.php if not admin or s-admin
    exit();
}


try {
    // Fetch pending payments from approved reservations
    $pendingQuery = "
        SELECT b.booking_id, u.first_name, u.last_name, s.service_name, p.payment_method, p.payment_status
        FROM bookings b
        JOIN users u ON b.user_id = u.user_id
        JOIN services s ON b.service_id = s.service_id
        JOIN payments p ON b.booking_id = p.booking_id
        WHERE p.payment_status = 'approved' AND b.status = 'approved'
        ORDER BY b.booking_id"; // Ensure proper ordering
    $pendingStmt = $pdo->prepare($pendingQuery);
    $pendingStmt->execute();
    $pendingBookings = $pendingStmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch finished payments from finished reservations
    $finishedQuery = "
        SELECT b.booking_id, u.first_name, u.last_name, s.service_name, p.payment_method, p.payment_status
        FROM bookings b
        JOIN users u ON b.user_id = u.user_id
        JOIN services s ON b.service_id = s.service_id
        JOIN payments p ON b.booking_id = p.booking_id
        WHERE p.payment_status = 'finished' AND b.status = 'finished'
        ORDER BY b.booking_id"; // Ensure proper ordering
    $finishedStmt = $pdo->prepare($finishedQuery);
    $finishedStmt->execute();
    $finishedBookings = $finishedStmt->fetchAll(PDO::FETCH_ASSOC);

    // Calculate total payment for finished bookings
    $totalFinishedQuery = "
        SELECT SUM(s.service_price) AS total_payment 
        FROM bookings b
        JOIN services s ON b.service_id = s.service_id
        JOIN payments p ON b.booking_id = p.booking_id
        WHERE p.payment_status = 'finished' AND b.status = 'finished'
    ";
    $totalFinishedStmt = $pdo->prepare($totalFinishedQuery);
    $totalFinishedStmt->execute();
    $totalFinishedRow = $totalFinishedStmt->fetch(PDO::FETCH_ASSOC);
    $totalFinishedPayment = $totalFinishedRow['total_payment'] ?? 0; // Default to 0 if no payment found

} catch (PDOException $e) {
    // Handle any PDO exceptions here
    echo "Error: " . $e->getMessage();
}
try {
    // Enable PDO error reporting
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Update payment_status based on bookings table status (pending or approved)
    $update_query = $pdo->prepare("
        UPDATE payments p
        JOIN bookings b ON p.booking_id = b.booking_id
        SET p.payment_status = b.status
        WHERE b.status IN ('pending', 'approved', 'finished')
    ");
    
    $update_query->execute();
    
} catch (PDOException $e) {
    echo "PDO Exception: " . $e->getMessage();
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
                    <th>Payment Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($pendingBookings)) : ?>
                    <?php foreach ($pendingBookings as $booking): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($booking['first_name'] . ' ' . $booking['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($booking['service_name']); ?></td>
                            <td><?php echo htmlspecialchars($booking['payment_method']); ?></td>
                            <td><?php echo htmlspecialchars($booking['payment_status']); ?></td>
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
        <button class="btn btn-danger" onclick="exportToExcel()">Export to Excel</button>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Finished Payment</th>
                    <th>Payment Method</th>
                    <th>Payment Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($finishedBookings)) : ?>
                    <?php foreach ($finishedBookings as $booking): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($booking['first_name'] . ' ' . $booking['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($booking['service_name']); ?></td>
                            <td><?php echo htmlspecialchars($booking['payment_method']); ?></td>
                            <td><?php echo htmlspecialchars($booking['payment_status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No finished payments found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <h3>Total Payment: PHP <?php echo number_format($totalFinishedPayment, 2); ?></h3>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="assets/js/main.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
    function exportToExcel() {
        fetch('export_payment.php')
            .then(response => {
                if (response.ok) return response.blob();
                throw new Error('Network response was not ok.');
            })
            .then(blob => {
                // Create a new URL for the blob
                const url = window.URL.createObjectURL(blob);
                // Create a new <a> element for the download
                const a = document.createElement('a');
                a.href = url;
                a.download = 'payment.csv'; // Specify the file name for download
                document.body.appendChild(a); // Append <a> to <body>
                a.click(); // Simulate click on <a> to start download
                window.URL.revokeObjectURL(url); // Clean up URL object
                a.remove(); // Remove <a> from <body>
            })
            .catch(error => {
                console.error('There was an error:', error);
            });
    }
    </script>
</body>
</html>
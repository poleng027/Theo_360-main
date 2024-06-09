<?php
include 'classes/database.php'; // Database connection file

// Fetch finished bookings
$finishedQuery = "SELECT firstname, lastname, package, payment_method FROM bookings WHERE status = 'finished'";
$finishedStmt = $pdo->prepare($finishedQuery);
$finishedStmt->execute();
$finishedBookings = $finishedStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch pending bookings
$pendingQuery = "SELECT firstname, lastname, package, payment_method FROM bookings WHERE status = 'pending'";
$pendingStmt = $pdo->prepare($pendingQuery);
$pendingStmt->execute();
$pendingBookings = $pendingStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch total payment for finished bookings
$totalFinishedQuery = "SELECT SUM(REPLACE(SUBSTRING_INDEX(package, ' - PHP ', -1), ',', '')) AS total_payment FROM bookings WHERE status = 'finished'";
$totalFinishedStmt = $pdo->prepare($totalFinishedQuery);
$totalFinishedStmt->execute();
$totalFinishedRow = $totalFinishedStmt->fetch(PDO::FETCH_ASSOC);
$totalFinishedPayment = $totalFinishedRow['total_payment'];
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
            <h2>Pending Payments</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Pending Payment</th>
                            <th>Payment Method</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pendingBookings as $booking): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($booking['firstname'] . ' ' . $booking['lastname']); ?></td>
                            <td><?php echo htmlspecialchars($booking['package']); ?></td>
                            <td><?php echo htmlspecialchars($booking['payment_method']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <h2>Finished Payments</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Payment</th>
                            <th>Payment Method</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($finishedBookings as $booking): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($booking['firstname'] . ' ' . $booking['lastname']); ?></td>
                            <td><?php echo htmlspecialchars($booking['package']); ?></td>
                            <td><?php echo htmlspecialchars($booking['payment_method']); ?></td>
                        </tr>
                        <?php endforeach; ?>
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

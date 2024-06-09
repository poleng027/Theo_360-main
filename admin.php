<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="./assets/css/style.css?v=<?php echo time();?>">
    <style>
        .cardBox {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
        }

        .card {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex: 1 1 300px;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
        }

        .card .numbers {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
        }

        .card .cardName {
            color: #777;
            margin-top: 5px;
        }

        .card .iconBx {
            font-size: 3rem;
            color: #00bcd4;
        }

        .card .iconBx ion-icon {
            color: #00bcd4;
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
                    <a href="admin.php">
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

            <!-- ======================= Cards ================== -->
            <?php
                require_once 'classes/database.php';

                // Fetch bookings data
                $pending = $approved = $finished = 0;
                $stmt = $pdo->prepare("SELECT status, COUNT(*) as count FROM bookings GROUP BY status");
                $stmt->execute();
                $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($bookings as $booking) {
                    switch($booking['status']) {
                        case 'pending':
                            $pending = $booking['count'];
                            break;
                        case 'approved':
                            $approved = $booking['count'];
                            break;
                        case 'finished':
                            $finished = $booking['count'];
                            break;
                    }
                }

                // Fetch feedback data
                $feedback_data = [];
                $stmt = $pdo->prepare("SELECT feedback, COUNT(*) as count FROM feedback GROUP BY feedback");
                $stmt->execute();
                $feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($feedbacks as $feedback) {
                    $feedback_data[$feedback['feedback']] = $feedback['count'];
                }

                // Fetch monthly report data
                $monthly_data = [];
                $stmt = $pdo->prepare("SELECT DATE_FORMAT(date, '%Y-%m') as month, COUNT(*) as count FROM bookings WHERE status = 'finished' GROUP BY month ORDER BY month");
                $stmt->execute();
                $monthly_reports = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($monthly_reports as $report) {
                    $monthly_data[$report['month']] = $report['count'];
                }
            ?>

            <div class="cardBox">
                <div class="card">
                    <div>
                        <div class="numbers"><?php echo $pending; ?></div>
                        <div class="cardName">Pending</div>
                    </div>
                    <div class="iconBx">
                        <ion-icon name="refresh-circle"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers"><?php echo $approved; ?></div>
                        <div class="cardName">Approved</div>
                    </div>
                    <div class="iconBx">
                        <ion-icon name="checkmark-circle"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers"><?php echo $finished; ?></div>
                        <div class="cardName">Finished</div>
                    </div>
                    <div class="iconBx">
                        <ion-icon name="checkmark-done-circle"></ion-icon>
                    </div>
                </div>
            </div>

            <!-- ================ Add Charts JS ================= -->
            <div class="chartsBx">
                <div class="chart">
                    <canvas id="chart-1"></canvas>
                    <h3>Feedback</h3>
                </div>
                <div class="chart">
                    <canvas id="chart-2"></canvas>
                    <h3>Monthly Report</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="assets/js/main.js"></script>

    <!-- ======= Charts JS ====== -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script>
        const ctx1 = document.getElementById('chart-1').getContext('2d');
        const feedbackData = {
            labels: <?php echo json_encode(array_keys($feedback_data)); ?>,
            datasets: [{
                label: 'Feedback Count',
                data: <?php echo json_encode(array_values($feedback_data)); ?>,
                backgroundColor: ['rgba(75, 192, 192, 0.2)'],
                borderColor: ['rgba(75, 192, 192, 1)'],
                borderWidth: 1
            }]
        };
        const chart1 = new Chart(ctx1, {
            type: 'bar',
            data: feedbackData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const ctx2 = document.getElementById('chart-2').getContext('2d');
        const monthlyData = {
            labels: <?php echo json_encode(array_keys($monthly_data)); ?>,
            datasets: [{
                label: 'Finished Bookings',
                data: <?php echo json_encode(array_values($monthly_data)); ?>,
                backgroundColor: ['rgba(153, 102, 255, 0.2)'],
                borderColor: ['rgba(153, 102, 255, 1)'],
                borderWidth: 1
            }]
        };
        const chart2 = new Chart(ctx2, {
            type: 'line',
            data: monthlyData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>
</html>

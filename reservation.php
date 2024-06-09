<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Management</title>
    <link rel="stylesheet" href="assets/css/reservation.css">
    <link rel="stylesheet" href="./assets/css/style.css?v=<?php echo time();?>">
    <style>
        .section {
            display: none;
        }
        .section.active {
            display: block;
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
            <!-- ======================= Reservations ================== -->
            <div class="container" id="approved-section" class="section">
                <h1>Approved Reservations</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Location</th>
                            <th>Event Title</th>
                            <th>Package</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="approved-reservations">
                        <?php
                        include("classes/database.php");
                        try {
                            $query = $pdo->query("SELECT * FROM bookings WHERE status = 'approved'");
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['firstname']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['lastname']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['time']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['location']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['event_title']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['package']) . "</td>";
                                echo "<td>
                                    <select class='status-dropdown' onchange='updateStatus(this, " . $row['id'] . ")'>
                                        <option value='approved'" . ($row['status'] == 'approved' ? ' selected' : '') . ">Approved</option>
                                        <option value='pending'" . ($row['status'] == 'pending' ? ' selected' : '') . ">Pending</option>
                                        <option value='finished'" . ($row['status'] == 'finished' ? ' selected' : '') . ">Finished</option>
                                    </select>
                                    <button onclick='saveStatus(this, " . $row['id'] . ")'>Save</button>
                                </td>";
                                echo "<td><button onclick='deleteReservation(" . $row['id'] . ")'>Delete</button></td>";
                                echo "</tr>";
                            }
                        } catch (Exception $e) {
                            echo "Error: " . $e->getMessage();
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="container" id="pending-section" class="section active">
                <h1>Pending Reservations</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Location</</th>
                            <th>Event Title</th>
                            <th>Package</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="pending-reservations">
                        <?php
                        try {
                            $query = $pdo->query("SELECT * FROM bookings WHERE status = 'pending'");
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['firstname']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['lastname']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['time']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['location']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['event_title']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['package']) . "</td>";
                                echo "<td>
                                    <select class='status-dropdown' onchange='updateStatus(this, " . $row['id'] . ")'>
                                        <option value='approved'" . ($row['status'] == 'approved' ? ' selected' : '') . ">Approved</option>
                                        <option value='pending'" . ($row['status'] == 'pending' ? ' selected' : '') . ">Pending</option>
                                        <option value='finished'" . ($row['status'] == 'finished' ? ' selected' : '') . ">Finished</option>
                                    </select>
                                    <button onclick='saveStatus(this, " . $row['id'] . ")'>Save</button>
                                </td>";
                                echo "<td><button onclick='deleteReservation(" . $row['id'] . ")'>Delete</button></td>";
                                echo "</tr>";
                            }
                        } catch (Exception $e) {
                            echo "Error: " . $e->getMessage();
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="container" id="finished-section" class="section">
                <h1>Finished Reservations</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Location</th>
                            <th>Event Title</th>
                            <th>Package</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="finished-reservations">
                        <?php
                        try {
                            $query = $pdo->query("SELECT * FROM bookings WHERE status = 'finished'");
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['firstname']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['lastname']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['time']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['location']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['event_title']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['package']) . "</td>";
                                echo "<td>
                                    <select class='status-dropdown' onchange='updateStatus(this, " . $row['id'] . ")'>
                                        <option value='approved'" . ($row['status'] == 'approved' ? ' selected' : '') . ">Approved</option>
                                        <option value='pending'" . ($row['status'] == 'pending' ? ' selected' : '') . ">Pending</option>
                                        <option value='finished'" . ($row['status'] == 'finished' ? ' selected' : '') . ">Finished</option>
                                    </select>
                                    <button onclick='saveStatus(this, " . $row['id'] . ")'>Save</button>
                                </td>";
                                echo "<td><button onclick='deleteReservation(" . $row['id'] . ")'>Delete</button></td>";
                                echo "</tr>";
                            }
                        } catch (Exception $e) {
                            echo "Error: " . $e->getMessage();
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<!-- ====== ionicons ======= -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

<script>
    function updateStatus(selectElement, reservationId) {
        var status = selectElement.value;
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "update_status.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("id=" + reservationId + "&status=" + status);
    }

    function saveStatus(buttonElement, reservationId) {
        var selectElement = buttonElement.previousElementSibling;
        var status = selectElement.value;
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "update_status.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var row = buttonElement.parentNode.parentNode;
                if (status == 'approved') {
                    document.getElementById('approved-reservations').appendChild(row);
                } else if (status == 'finished') {
                    document.getElementById('finished-reservations').appendChild(row);
                } else {
                    document.getElementById('pending-reservations').appendChild(row);
                }
            }
        }
        xhr.send("id=" + reservationId + "&status=" + status);
    }

    function deleteReservation(reservationId) {
        if (confirm("Are you sure you want to delete this reservation?")) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "delete_reservation.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    location.reload();
                }
            }
            xhr.send("id=" + reservationId);
        }
    }
</script>
</body>
</html>

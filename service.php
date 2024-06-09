<?php
include("classes/database.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addPackage'])) {
        $serviceName = $_POST['serviceName'];
        $serviceDesc = $_POST['serviceDesc'];
        $servicePrice = $_POST['servicePrice'];

        // Insert the new service into the database
        $stmt = $pdo->prepare("INSERT INTO services (service_name, service_desc, service_price) VALUES (?, ?, ?)");
        $stmt->execute([$serviceName, $serviceDesc, $servicePrice]);
    } elseif (isset($_POST['delete'])) {
        $serviceId = $_POST['id'];

        // Delete the service from the database
        $stmt = $pdo->prepare("DELETE FROM services WHERE service_id = ?");
        $stmt->execute([$serviceId]);
    } elseif (isset($_POST['editPackage'])) {
        $serviceId = $_POST['id'];
        $serviceName = $_POST['editServiceName'];
        $serviceDesc = $_POST['editServiceDesc'];
        $servicePrice = $_POST['editServicePrice'];

        // Update the service in the database
        $stmt = $pdo->prepare("UPDATE services SET service_name = ?, service_desc = ?, service_price = ? WHERE service_id = ?");
        $stmt->execute([$serviceName, $serviceDesc, $servicePrice, $serviceId]);
    }
}

// Fetch all services from the database
$services = $pdo->query("SELECT * FROM services")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="./assets/css/style.css?v=<?php echo time(); ?>">
    <style>

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        table th, table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #69185B;
            color: #fff;
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        table input[type="text"], 
        table input[type="number"] {
            width: calc(100% - 20px);
            padding: 8px;
            margin: 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        table button {
            padding: 8px 12px;
            margin: 5px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        table .edit-btn {
            background-color: #28a745;
            color: #fff;
        }
        table .edit-btn:hover {
            background-color: #218838;
        }
        table .delete-btn {
            background-color: #dc3545;
            color: #fff;
        }
        table .delete-btn:hover {
            background-color: #c82333;
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
            <!-- =============== Main Content ================ -->
            <div class="main-content">
                <h2>Package Services</h2>
                <div class="add-service">
                    <h3>Add New Service</h3>
 
                    <form method="POST">
                        <input type="text" class="form-control" name="serviceName" placeholder="Service Name" required>
                        <input type="text" class="form-control" name="serviceDesc" placeholder="Description" required>
                        <input type="number" step="0.01" class="form-control" name="servicePrice" placeholder="Price" required>
                        <button type="submit" name="addPackage">Add Service</button>
                    </form>
                </div><br>
 
                <div class="service-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Service Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($services as $service) { ?>
                            <tr>
                                <form method="post">
                                    <td>
                                        <input type="text" name="editServiceName" value="<?php echo htmlspecialchars($service['service_name']); ?>" required>
                                    </td>
                                    <td>
                                        <input type="text" name="editServiceDesc" value="<?php echo htmlspecialchars($service['service_desc']); ?>" required>
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" name="editServicePrice" value="<?php echo htmlspecialchars($service['service_price']); ?>" required>
                                    </td>
                                    <td>
                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($service['service_id']); ?>">
                                        <button type="submit" class="edit-btn" name="editPackage">Save</button>
                                        <button type="submit" class="delete-btn" name="delete">Delete</button>
                                    </td>
                                </form>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
 
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

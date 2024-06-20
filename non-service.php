<?php

include("classes/database.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Theo360 Services</title>
    <style>
        body {
            margin: 0;
            padding: 100px;
            font-family: Arial, sans-serif;
            background-image: url('./assets/imgs/bg.png');
            background-size: cover;
            background-position: center;
        }

        header {
            background-color: rgba(58, 29, 97, 0.9);
            color: white;
            text-align: center;
            padding: 60px 0;
        }

        h1 {
            margin: 0;
        }

        .packages {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            align-items: flex-start;
            margin-top: 20px;
            padding: 0 20px;
        }

        .package {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            margin: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            flex: 1 0 30%;
            box-sizing: border-box;
        }

        .package h2 {
            color: rgba(58, 29, 97, 0.9);
            font-weight: bold;
            text-shadow: 0 0 20px rgba(97, 29, 72, 0.9);
            font-size: 30px;
            font-family: Georgia, 'Times New Roman', Times, serif;
        }

        .package ul {
            list-style-type: none;
            padding: 0;
        }

        .package ul li {
            margin-bottom: 10px;
        }

        .package p {
            margin-top: 20px;
            font-weight: bold;
            color: rgba(58, 29, 97, 0.9);
        }

        .package button {
            background-color: rgba(58, 29, 97, 0.9);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .package button:hover {
            background-color: #a52997;
        }

        footer {
            background-color: rgba(58, 29, 97, 0.9);
            color: white;
            text-align: center;
            padding: 20px 0;
            margin-top: 35px;
        }

        .package p.price {
            margin-top: 20px;
            font-weight: bold;
            color: rgba(58, 29, 97, 0.9);
            text-shadow: 0 0 25px rgba(165, 36, 142, 0.9);
        }
    </style>
</head>
<body>
    <?php include("non-user-navbar.php"); ?>
    <header>
        <h1>Our Services</h1>
    </header>

    <section class="packages">
        <?php
        // Fetch services from the database
        $stmt = $pdo->query("SELECT * FROM services");
        $services = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($services as $service) {
        ?>
        <div class="package">
            <h2><?php echo htmlspecialchars($service['service_name']); ?></h2>
            <ul>
                <?php $descArray = explode(',', $service['service_desc']); ?>
                <?php foreach ($descArray as $desc) { ?>
                <li><?php echo htmlspecialchars(trim($desc)); ?></li>
                <?php } ?>
            </ul>
            <p class="price">Price: PHP <?php echo htmlspecialchars($service['service_price']); ?></p>
            <a href="book-u.php"><button>Book Now</button></a>
        </div>
        <?php } ?>
    </section>

</body>
</html>

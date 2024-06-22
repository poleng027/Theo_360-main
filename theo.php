<?php
session_start();
include("classes/database.php");

// Database connection details
$host = '127.0.0.1';
$db = 'theo360';
$user = 'root';
$pass = '';

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch main video URL
$sql_main_video = "SELECT url FROM videos WHERE title = 'Landing Page'";
$result_main_video = $conn->query($sql_main_video);

if ($result_main_video->num_rows > 0) {
    $row_main_video = $result_main_video->fetch_assoc();
    $main_video_url = $row_main_video['url'];
} else {
    $main_video_url = '';
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video and Text Layout</title>
</head>
<style>
    <style>
            * {
            box-sizing: border-box;
        }


            body {         
            background-image: url(./assets/imgs/background.png); 
            margin: 0;
            padding: 0;
            height: 100vh;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
            color: #fff;
            overflow: hidden;
        }

        .container {
            display: flex;
            width: 80%;
            max-width: 1200px;
            height: 80%;
            background-color: rgba(0, 0, 0, 0.5);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            overflow: hidden;
        }

        .text-section {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .text-section h1 {
            font-size: 36px;
            margin-bottom: 20px;
            text-shadow: 0 0 10px rgba(0, 0, 0, 0.7);
        }

        .text-section p {
            font-size: 15px;
            line-height: 1.6;
            text-shadow: 0 0 10px rgba(0, 0, 0, 0.7);
            text-align: justify;
            transition: color 0.5s ease-in-out;
        }

        .text-section .book-now-btn {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 18px;
            color: #fff;
            background-color: #4c1374; /* Purple color */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        .text-section .book-now-btn:hover {
            background-color: #8b00ff; /* Lighter purple color */
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
        }

        .video-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            
        }

        .video-section video {
            width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }
 
        .btn {
            width: 15;
            padding: 10px;
            background-color: #4a148c;
            border: none;
            border-radius: 20px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

</style>
</style>
<body>
<?php include("non-user-navbar.php");?>    

    <div class="container">
        <div class="text-section">
            <h1>Theo360</h1>
            <p>
            Founded on the principle that every moment holds beauty and significance, Theo360 combines advanced technology with creative expertise to produce immersive, emotionally resonant videos tailored to each client's unique vision. Their client-centric approach emphasizes personalized service and strong relationships, ensuring satisfaction from initial consultation to final edit. Versatile and adaptable, Theo360 remains at the industry's forefront, creating impactful visual stories that inspire and connect people.
            </p>
            <a href="book-u.php"><button class="book-now-btn">Book Now</button></a>
        </div>
        <div class="video-section">
            <?php if ($main_video_url): ?>
                <video autoplay muted loop>
                    <source src="<?php echo $main_video_url; ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            <?php else: ?>
                <p>Main video not found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

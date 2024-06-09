<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video and Text Layout</title>
</head>
<style>
            body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background-image: url(./assets/imgs/background.png); /* Replace with your background image URL */
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
            color: #fff;
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
<body>
<?php include("navbar-u.php");?>    

    <div class="container">
        <div class="text-section">
            <h1>Theo360</h1>
            <p>
            Founded on the principle that every moment holds beauty and significance, Theo360 combines advanced technology with creative expertise to produce immersive, emotionally resonant videos tailored to each client's unique vision. Their client-centric approach emphasizes personalized service and strong relationships, ensuring satisfaction from initial consultation to final edit. Versatile and adaptable, Theo360 remains at the industry's forefront, creating impactful visual stories that inspire and connect people.
            </p>
            <a href="book-u.php"><button class="book-now-btn">Book Now</button></a>

        </div>
        <div class="video-section">
            <video autoplay muted loop>
                <source src="./assets/imgs/0047.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    </div>
</body>
</html>

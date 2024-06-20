<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <!-- Link to Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background: url(./assets/imgs/bg.png);
        background-size: cover;
        background-position: center;
    }
    .container {
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        max-width: 800px; 
        width: 90%;
        margin-top: 50px;
        text-align: center;
        background-color: #e7d5e8;
    }
    h2 {
        font-size: 2em;
        color: #333;
        margin-bottom: 20px;
    }
    .subheading {
        font-size: 1.2em;
        color: #666;
        margin-bottom: 40px;
    }
    .icons {
        font-size: 1.5em;
        margin-bottom: 20px;
        display: flex; 
        justify-content: center; 
    }
    .icons i {
        margin: 0 20px;
    }
    .contact-info {
        display: flex;
        flex-direction: column;
        align-items: center;
        color: #666;
    }
    .contact-info p {
        margin: 10px 0;
        font-size: 1em;
    }
    .additional-info {
        margin-top: 20px;
        color: #666;
    }
</style>
<body>
<?php include("non-user-navbar.php");?>   

    <div class="container">
        <h2>Contact Us</h2>
        <p class="subheading">Have You Got Any Questions?</p>
        <div class="icons">
            <a href="https://www.facebook.com/theo360studio"><i class="fab fa-facebook-f"></i></a>
            <a href="https://www.instagram.com/theo360studio"><i class="fab fa-instagram"></i></a>
            <a href="https://www.tiktok.com/@theo360studio"><i class="fab fa-tiktok"></i></a>
        </div>
        <div class="contact-info">
            <p>Phone: 0915 801 8416</p>
            <p>Email: theo360studio@gmail.com</p>
        </div>
        <div class="additional-info">
            <p>Feel free to reach out to us for any inquiries or assistance. We're here to help!</p>
        </div>
    </div>
</body>
</html>

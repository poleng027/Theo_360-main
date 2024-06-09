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
    height: 450px;
    text-align: center;
    background-color: #e7d5e8;
}
 
h2 {
    font-size: 2em;
    color: #333;
    margin-bottom: 80px;
}
 
.subheading {
    font-size: 1.2em;
    color: #666;
    margin-bottom: 80px;
}
 
.icons {
    font-size: 1.5em;
    margin-bottom: 40px;
    display: flex; 
    justify-content: center; 
}
 
.icons i {
    margin: auto 50px;
}
 
.contact-info {
    display: flex;
    justify-content: center;
   
}
 
.contact-info p {
    margin: 50px;
    color: #666;
    margin-top: unset;
}
 
.contact-info span {
    display: flex;
    align-items: center;
    margin-top: 10px; 
}
 
.contact-info span p {
    margin: 0 10px; 
}
 
.additional-info {
    margin-top: 20px;
    color: #666;
}
</style>
<body>
<?php include("navbar-u.php");?>   

    <div class="container">
        <h2>Contact Us</h2>
        <p class="subheading">Have You Got Any Questions?</p>
        <div class="icons">
            <i class="fab fa-facebook-f"></i>
            <i class="fab fa-tiktok"></i>
            <i class="fas fa-envelope"></i>
            <i class="fas fa-phone-alt"></i>
        </div>
        <div class="contact-info">
            <p>Facebook</p>
            <p>TikTok</p>
            <p>Email</p>
            <p>Call Us</p>
        </div>
        <div class="additional-info">
            <p>Feel free to reach out to us for any inquiries or assistance. We're here to help!</p>
        </div>
    </div>
</body>
</html>
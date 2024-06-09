<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - How Theo360 works?</title>
    <!-- Link to Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<!-- ==================== Style ==================== -->
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
    background-image: url('./assets/imgs/bg.png');
    background-size: cover;
    background-position: center;
}

.video-container {
    flex: 0 0 25%; 
    height: auto;
    padding: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
}

video {
    width: 100%;
    height: auto;
    border-radius: 10px; 
}

.container {
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    max-width: 500px;
    width: 40%;
    text-align: center;
    animation: fadeIn 2s ease-in-out;
    background-color: rgba(58, 29, 97, 0.9);
}

h1 {
    font-size: 2.5em;
    color: #ded5d5; 
    margin-bottom: 20px;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

ul {
    list-style-type: none;
    padding-left: 20px;
    text-align: left;
}

ul li {
    font-size: 1.2em;
    color: #ded5d5;
    margin-bottom: 10px;
    line-height: 1.5;
}

ul li h2{
    font-size: 20px;
    font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
}

ul li p{
    font-size: 15px;

}
.book-now {
    margin-top: 20px;
    padding: 10px 20px;
    font-size: 1em;
    color: white;
    background-color: #6a0dad;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.book-now:hover {
    background-color: #7a0dde;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

</style>

<body>
<?php include("navbar-u.php");?>   
    <!-- ==================== Main ==================== -->
    <div class="video-container">
        <video autoplay muted loop>
            <source src="./assets/imgs/0130.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
    
    <div class="container">
        <h1>How Theo360 works?</h1>
        <ul>
            <li>
                <div>
                    <i class="fas fa-camera"></i>
                    <h2>Show your best pose</h2>
                    <p>Guest steps onto our 360 platform and as the arm starts to rotate, we begin to start recording a 12 second video.</p>
                </div>
            </li>
            <li>
                <div>
                    <i class="fas fa-video"></i>
                    <h2>View your 360 Video</h2>
                    <p>After making the 360 video, our 360 video software processes & renders the video and guests can instantly view the 360 Video on the big screen.</p>
                </div>
            </li>
            <li>
                <div>
                    <i class="fas fa-download"></i>
                    <h2>Download and Share</h2>
                    <p>Guests can make their way to our sharing stations to view their videos and easily download the video via QR code then share it to social media.</p>
                </div>
            </li>
        </ul>
    </div>
</body>
</html>

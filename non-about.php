<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - How Theo360 works?</title>
    <!-- Link to Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Link to your custom CSS -->

</head>
<style>
        body {         
        background-image: url(./assets/imgs/bg.png); 
        margin: 0;
        padding: 100px;
        height: 100vh;
        background-size: cover;
        background-position: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        font-family: Arial, sans-serif;
        color: #fff;
    }

    @keyframes gradientAnimation {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }

    .video-background {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
    }

    #bg-video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .content {
        position: relative;
        z-index: 1;
        width: 90%;
        max-width: 1200px;
        text-align: center;
        padding: 20px;
        margin-bottom: 40px;
    }

    header {
        margin-bottom: 20px;
    }

    header h1 {
        font-size: 2.5em;
        color: #cdcbe6;
        font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .main-container {
        display: flex;
        justify-content: center;
        align-items: bottom;
        gap: 20px;
        padding-top: 500px;
        max-width: 900px; /* Adjusted width */
        margin: 20px auto; /* Adjusted margin */
        
    }

    .video-container {
        flex: 1;
        height: auto;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .video-container video {
        width: 100%;
        height: auto;
        border-radius: 10px;
    }

    .container {
        flex: 1;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        max-width: 500px;
        text-align: center;
        animation: fadeIn 2s ease-in-out;
        background-color: rgba(58, 29, 97, 0.9);
        margin-bottom: 40px;
    }

    h1 {
        font-size: 2.5em;
        color: #ded5d5;
        margin-bottom: 20px;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .container ul {
        list-style-type: none;
        padding-left: 20px;
        text-align: left;
    }

    .container ul li {
        font-size: 1.2em;
        color: #ded5d5;
        margin-bottom: 10px;
        line-height: 1.5;
    }

    .container ul li h2 {
        font-size: 20px;
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    }

    .container ul li p {
        font-size: 15px;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .video-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    .video-container-grid {
        background-color: rgba(0, 0, 0, 0.5);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .video-container-grid video {
        width: 100%;
        height: 200px;
        border-radius: 10px;
    }

    .video-container-grid p {
        margin-top: 10px;
        color: #00bcd4;
        font-size: 1.2em;
    }

    .video-container-grid:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
    }

</style>
<body>
    <?php include("non-user-navbar.php"); ?>

    <!-- Main container -->
    <div class="main-container">
        <?php
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
        $sql_main_video = "SELECT url FROM videos WHERE title = 'Main Video'";
        $result_main_video = $conn->query($sql_main_video);

        if ($result_main_video->num_rows > 0) {
            $row_main_video = $result_main_video->fetch_assoc();
            $main_video_url = $row_main_video['url'];

            echo '<div class="video-container">';
            echo '<video autoplay muted loop>';
            echo '<source src="' . $main_video_url . '" type="video/mp4">';
            echo 'Your browser does not support the video tag.';
            echo '</video>';
            echo '</div>';
        } else {
            echo "Main video not found";
        }

        // Fetch previous event videos
        $sql_previous_events = "SELECT * FROM videos WHERE title LIKE 'Gallery%'";
        $result_previous_events = $conn->query($sql_previous_events);

        ?>
        <div class="container">
            <h1>How Theo360 works?</h1>
            <ul>
                <li>
                    <div>
                        <i class="fas fa-camera"></i>
                        <h2>Show your best pose</h2>
                        <p>Guest steps onto our 360 platform and as the arm starts to rotate, we begin to start recording a 12-second video.</p>
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
    </div>

    <!-- Previous events -->
    <div class="content">
        <header>
            <h1>CHECK OUR PREVIOUS EVENTS:</h1>
        </header>
        <div class="video-grid">
            <?php
            if ($result_previous_events->num_rows > 0) {
                while($row_event = $result_previous_events->fetch_assoc()) {
                    echo '<div class="video-container-grid">';
                    echo '<video controls autoplay muted>';
                    echo '<source src="' . $row_event["url"] . '" type="video/mp4">';
                    echo 'Your browser does not support the video tag.';
                    echo '</video>';
                    echo '</div>';
                }
            } else {
                echo "No previous events found";
            }

            // Close connection
            $conn->close();
            ?>
        </div>
    </div>

</body>
</html>

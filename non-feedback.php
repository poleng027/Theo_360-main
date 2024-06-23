<?php
session_start();


// Database connection details
$host = '127.0.0.1';
$db = 'theo360';
$user = 'root';
$pass = '';

try {
    // Create a PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch feedback including username from the database, ordered by created_at descending
    $sql = "SELECT f.feedback, f.created_at, u.username 
            FROM feedback f 
            JOIN users u ON f.username = u.username 
            ORDER BY f.created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <title>Customer Feedback</title>

    <style>
             * {
                box-sizing: border-box;
            }
            
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
                display: flex;
                justify-content: center;
                align-items: flex-start;
                flex-wrap: wrap;
            }
            
            .panel-container {
                background-color: #fff;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
                border-radius: 10px;
                font-size: 90%;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                text-align: center;
                padding: 30px;
                max-width: 600px;
                margin: 0 20px;
            }
            
            .panel-container strong {
                line-height: 20px;
                background-color: #1A1F4F; /* Added background color */
                color: #fff; /* Text color */
                padding: 10px 20px; /* Padding inside strong element */
                border-radius: 8px; /* Rounded corners */
                width: 103%;
                padding-top: 3%;
                margin-top: -15px;
                border-radius: 3%;
                font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
            
            
            }
            
            .ratings-container {
                display: flex;
                margin: 20px 0;
            }
            
            .rating {
                flex: 1;
                cursor: pointer;
                padding: 20px;
                margin: 10px 5px;
                text-align: center;
            }
            
            .rating:hover,
            .rating.active {
                border-radius: 4px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            }
            
            .rating img {
                width: 40px;
            }
            
            .rating small {
                color: #555;
                display: inline-block;
                margin: 10px 0 0;
            }
            
            .rating:hover small,
            .rating.active small {
                color: #111;
            }
            
            .btn {
                background-color: #1A1F4F;
                color: #fff;
                border: 0;
                border-radius: 4px;
                padding: 12px 30px;
                cursor: pointer;
                font-family: monospace;
            }
            
            .btn:focus {
                outline: 0;
            }
            
            .btn:active {
                transform: scale(0.98);
            }
            
            .fa-heart {
                color: red;
                font-size: 30px;
                margin-bottom: 20px;
            }
            
            .feedback-list {
                background-color: #f5f5f5;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
                border-radius: 10px;
                padding: 20px;
                max-width: 600px;
                margin: 0 20px;
                overflow-y: auto; /* Add scrollbar when content exceeds container height */
                max-height: 400px; /* Adjust max height as needed */
            }
            
            .feedback-list::-webkit-scrollbar {
                width: 10px; /* Width of the scrollbar */
            }
            
            .feedback-list::-webkit-scrollbar-track {
                background-color: #ccc; /* Color of the scrollbar track */
                border-radius: 5px; /* Rounded corners of the track */
            }
            
            .feedback-list::-webkit-scrollbar-thumb {
                background-color: #888; /* Color of the scrollbar thumb */
                border-radius: 5px; /* Rounded corners of the thumb */
            }
            
            .feedback-list::-webkit-scrollbar-thumb:hover {
                background-color: #69185B; /* Color of the scrollbar thumb on hover */
            }
            
            
            .feedback-list h2 {
                text-align: center;
                margin-bottom: 20px;
                position: relative;
                color: #1A1F4F;
                font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
            }
            
            .feedback-list h2::after {
                content: '';
                display: block;
                width: 100%;
                height: 2px;
                background-color: #1A1F4F;
                margin: 10px auto 0;
            }
            
            .feedback-item {
                padding: 15px;
                margin-bottom: 10px;
                padding-bottom: 10px;
                border-bottom: 1px solid #1A1F4F;
            }
            
            .feedback-item:last-child {
                border-bottom: none;
                margin-bottom: 0;
                padding-bottom: 0;
            }
            
            .feedback-item p {
                margin: 5px 0;
            }
            
            .feedback-item strong {
                display: flex;
                align-items: center;
            }
            
            .feedback-item .feedback-text {
                margin-top: 5px;
            }
            
            .feedback-item .feedback-date {
                font-size: 12px;
                color: #888;
                margin-top: 5px;
            }
            
            .feedback-item .username {
                font-weight: bold;
                color: #333;
                margin-bottom: 5px;
            }
            
            
            .feedback-list {
                background-color: #f5f5f5;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
                border-radius: 10px;
                padding: 20px;
                max-width: 600px;
                margin: 0 20px;
                overflow-y: auto; /* Add scrollbar when content exceeds container height */
                max-height: 400px; /* Adjust max height as needed */
            }
            
            .feedback-list::-webkit-scrollbar {
                width: 10px; /* Width of the scrollbar */
            }
            
            .feedback-list::-webkit-scrollbar-track {
                background-color: #ccc; /* Color of the scrollbar track */
                border-radius: 5px; /* Rounded corners of the track */
            }
            
            .feedback-list::-webkit-scrollbar-thumb {
                background-color: #888; /* Color of the scrollbar thumb */
                border-radius: 5px; /* Rounded corners of the thumb */
            }
            
            .feedback-list::-webkit-scrollbar-thumb:hover {
                background-color: #69185B; /* Color of the scrollbar thumb on hover */
            }
    </style>
</head>
<body>
    <?php include("non-user-navbar.php"); ?>

    <div class="panel-container" id="panel">
        <strong>How satisfied are you with our <br/>customer support performance?</strong>
        <div class="ratings-container">
            <div class="rating" data-value="1">
                <img src="./emoticon/unhappy.png" alt="unhappy">
                <small>Unhappy</small>
            </div>

            <div class="rating" data-value="2">
                <img src="./emoticon/neutral-face.png" alt="neutral">
                <small>Neutral</small>
            </div>

            <div class="rating" data-value="3">
                <img src="./emoticon/satisfied.png" alt="satisfied">
                <small>Satisfied</small>
            </div>

            <div class="rating" data-value="4">
                <img src="./emoticon/thumbs-up.png" alt="thumbs-up">
                <small>Good</small>
            </div>

            <div class="rating" data-value="5">
                <img src="./emoticon/happy-face.png" alt="happy-face">
                <small>Amazing</small>
            </div>
        </div>
        <form id="feedbackForm" method="POST" action="feedback.php">
            <input type="hidden" name="feedback" id="selectedFeedback" value="1">
            <button type="submit" class="btn" id="send">Send Review</button>
        </form>
    </div>

    <div class="feedback-list">
        <h2>Customer Feedback</h2>
        <?php
            foreach ($feedbacks as $feedback) {
                echo '<div class="feedback-item">';
                echo '<p class="username">User: ' . htmlspecialchars($feedback["username"]) . '</p>';
                echo '<strong>Feedback: ' . htmlspecialchars($feedback["feedback"]) . '</strong>';
                echo '<p class="feedback-date">Date: ' . htmlspecialchars($feedback["created_at"]) . '</p>';
                echo '</div>';
            }
        ?>
    </div>

    <script>
        const ratings = document.querySelectorAll('.rating');
        const ratingsContainer = document.querySelector('.ratings-container');
        const selectedFeedback = document.getElementById('selectedFeedback');
        const feedbackForm = document.getElementById('feedbackForm');
        const panel = document.getElementById('panel');

        ratingsContainer.addEventListener('click', (e) => {
            if (e.target.closest('.rating')) {
                removeActive();
                const rating = e.target.closest('.rating');
                rating.classList.add('active');
                selectedFeedback.value = rating.dataset.value;
            }
        });

        feedbackForm.addEventListener('submit', (e) => {
            e.preventDefault();
            // Submit the form using fetch
            fetch('feedback.php', {
                method: 'POST',
                body: new FormData(feedbackForm)
            })
            .then(response => response.text())
            .then(result => {
                panel.innerHTML = `
                    <i class="fas fa-heart"></i>
                    <strong>Thank You!</strong>
                    <br>
                    <strong>Feedback: ${selectedFeedback.value}</strong>
                    <p>We'll use your feedback to improve our customer support</p>
                `;
            })
            .catch(error => console.error('Error:', error));
        });

        function removeActive() {
            ratings.forEach(rating => rating.classList.remove('active'));
        }
    </script>
</body>
</html>

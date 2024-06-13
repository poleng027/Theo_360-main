<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <title>Customer Feedback</title>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Montserrat&display=swap');

        * {
            box-sizing: border-box;
        }

        body {
            background-color: #442063;
            font-family: 'Montserrat', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            overflow: hidden;
            margin: 0;
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
        }

        .panel-container strong {
            line-height: 20px;
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
            background-color: #302d2b;
            color: #fff;
            border: 0;
            border-radius: 4px;
            padding: 12px 30px;
            cursor: pointer;
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
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php include("navbar-u.php");?>    
    <div id="panel" class="panel-container">
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

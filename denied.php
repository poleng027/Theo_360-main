<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied</title>
    <style>
        :root{
            --blue: #1A1F4F;
            --white: #fff;
            --gray: #f5f5f5;
            --black1: #222;
            --black2: #999;
            --purple: #69185B;
        }
        body {
            font-family: Arial, sans-serif;
            background: url(./assets/imgs/bg.png);
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        .container {
            text-align: center;
            background-color: var(--white);
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 300px;
        }

        h1 {
            color: var(--purple);
            margin-bottom: 10px;
        }

        p {
            color: var(--black2);
            margin-bottom: 20px;
        }

        .button {
            background-color: var(--blue);
            color: var(--white);
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: purple; /* Darken the blue on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Access Denied</h1>
        <p>You are not allowed to access the admin page.</p>
        <a href="landing-page-u.php" class="button">OK</a>
    </div>
</body>
</html>

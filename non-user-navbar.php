
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar Navigation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<!-- ==========Style========== -->
<style>
    * {
        box-sizing: border-box;
    }

    body {         
        margin: 0;
        padding: 0;
        height: 100vh;
        background-size: cover;
        background-position: center;
        align-items: center;
        justify-content: center;
        font-family: Arial, sans-serif;
    }

    .navbar {
        width: 100%;
        background-color: rgba(58, 29, 97, 0.9); 
        position: fixed;
        top: 0;
        left: 0;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 20px;
    }

    .navbar-dropdown {
        padding: 15px;
        background-color: rgba(42, 23, 67, 0.9);
        color: white;
        font-size: 1.2em;
        text-transform: uppercase;
        border-right: 1px solid #7a0dde;
    }

    .navbar-dropdown a {
        color: white;
        text-decoration: none;
    }

    #nav {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
    }

    #nav li {
        display: flex;
        align-items: center;
    }

    #nav li:not(:last-child) {
        margin-right: 10px;
    }

    #nav a {
        display: block;
        padding: 15px 20px;
        color: white;
        text-decoration: none;
        font-size: 1.1em;
        position: relative;
        transition: background-color 0.3s ease;
    }

    #nav a .fa {
        margin-right: 10px;
    }

    #nav .has_sub ul {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        background-color: #5a0cae;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        padding: 0;
        margin: 0;
        list-style: none;
    }

    #nav .has_sub:hover ul {
        display: block;
    }

    #nav .has_sub ul li {
        width: 200px;
    }

    #nav .has_sub ul a {
        padding-left: 30px;
    }

    #nav a:hover {
        background-color: #7a0dde;
        box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.5);
    }

    #nav .pull-right {
        float: right;
    }

    /* New styles for active state */
    #nav a.active, #nav a.active:hover {
        background-color: #7a0dde;
        box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.5);
    }
</style>
<body>
    <div class="navbar">
        <div class="navbar-dropdown"><a href="theo.php">Theo360</a></div>

        <!-- Navbar navigation -->
        <ul id="nav">
          <!-- Main service with font awesome icon -->
          <li class="open"><a href="non-about.php"><i class="fa fa-info-circle"></i> About Us</a></li>
          <li class="has_sub">
            <a href="non-service.php"><i class="fa fa-cogs"></i> Services <span class="pull-right"><i class="fa fa-chevron-right"></i></span></a>
          </li>  
          <li><a href="non-contact.php"><i class="fa fa-envelope"></i> Contact Us</a></li> 
          <li><a href="non-feedback.php"><i class="fa fa-star"></i> Feedback</a></li> 
          <li><a href="index.php"><i class="fa fa-sign-out"></i>Log In/ Sign Up</a></li>
        </ul>
    </div>
</body>
        <script>
        // JavaScript to handle active class on navbar
        document.addEventListener('DOMContentLoaded', function() {
            var navLinks = document.querySelectorAll('#nav a');
            navLinks.forEach(function(link) {
                link.addEventListener('click', function(event) {
                    navLinks.forEach(function(navLink) {
                        navLink.classList.remove('active');
                    });
                    this.classList.add('active');
                });
            });

            // Set active class based on current URL
            var currentUrl = window.location.pathname;
            navLinks.forEach(function(link) {
                if (link.getAttribute('href') === currentUrl) {
                    link.classList.add('active');
                }
            });
        });
    </script>

</html>

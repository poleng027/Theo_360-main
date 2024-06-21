<?php
include("classes/database.php");
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php"); // Redirect to login page if not logged in
    exit();
}

// Check if the user is an admin or s-admin
if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 's-admin') {
    header("Location: denied.php"); // Redirect to denied.php if not admin or s-admin
    exit();
}

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

// Function to sanitize input data
function sanitize_input($data) {
    $data = trim($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Insert new video
if (isset($_POST['add'])) {
    $title = sanitize_input($_POST['title']);

    if (isset($_FILES['video']['name']) && $_FILES['video']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["video"]["name"]);
        $uploadOk = 1;
        $videoFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file is an actual video
        $allowedMimeTypes = array("video/mp4", "video/x-msvideo", "video/quicktime", "video/3gpp", "video/mpeg");
        if (in_array($_FILES['video']['type'], $allowedMimeTypes)) {
            $uploadOk = 1;
        } else {
            echo "File is not a video.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["video"]["size"] > 500000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($videoFileType != "mp4" && $videoFileType != "avi" && $videoFileType != "mov" && $videoFileType != "3gp" && $videoFileType != "mpeg") {
            echo "Sorry, only MP4, AVI, MOV, 3GP, & MPEG files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["video"]["tmp_name"], $target_file)) {
                $url = $target_file;
                $sql_insert = "INSERT INTO videos (title, url) VALUES ('$title', '$url')";

                if ($conn->query($sql_insert) === TRUE) {
                    echo "New video added successfully";
                } else {
                    echo "Error: " . $sql_insert . "<br>" . $conn->error;
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
}

// Delete video
if (isset($_GET['delete'])) {
    $id = sanitize_input($_GET['delete']);

    $sql_delete = "DELETE FROM videos WHERE id='$id'";

    if ($conn->query($sql_delete) === TRUE) {
        echo "Video deleted successfully";
    } else {
        echo "Error deleting video: " . $conn->error;
    }
}

// Fetch videos for display
$sql_select = "SELECT * FROM videos";
$result = $conn->query($sql_select);

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Manage Videos</title>
    <!-- Link to Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 20px;
        }

        h2 {
            color: #333;
        }

        h3 {
            color: white;
            background-color: #69185B;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        form {
            margin-top: 10px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
        button {
            width: calc(100% - 20px);
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            margin-top: 20px;
        }

        table th, table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #69185B;
            color: #fff;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        table input[type="text"],
        table input[type="number"] {
            width: calc(100% - 20px);
            padding: 8px;
            margin: 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        table button {
            padding: 8px 12px;
            margin: 5px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        table .edit-btn {
            background-color: #28a745;
            color: #fff;
        }

        table .edit-btn:hover {
            background-color: #218838;
        }

        table .delete-btn {
            background-color: #dc3545;
            color: #fff;
        }

        table .delete-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <?php include("sidebar.php"); ?>   
    <h2>Admin Panel - Manage Videos</h2>

    <!-- Add new video form -->
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
        <h3>Add New Video</h3>
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br><br>
        <label for="video">Select Video:</label>
        <input type="file" id="video" name="video" accept="video/*" required><br><br>
        <button type="submit" name="add">Add Video</button>
    </form>

    <hr>

    <!-- Display existing videos and provide options to delete -->
    <h3>Manage Videos</h3>
    <table>
        <thead>
            <tr>
                <th>Video Title</th>
                <th>Video URL</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['title'] . "</td>";
                    echo "<td>" . $row['url'] . "</td>";
                    echo "<td>";
                    echo '<a href="?delete=' . $row['id'] . '" onclick="return confirm(\'Are you sure?\')">Delete</a>';
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No videos found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

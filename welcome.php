<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "9099";
$dbname = "majorprojectdb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
    <link rel="stylesheet" href="style.css"> <!-- External CSS -->
    
    <style>
        /* Box container */
        .action-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 50px; /* Increased gap */
            margin-top: 50px;
        }

        /* Box styling */
        .action-box {
            width: 350px;  /* Increased width */
            height: 250px; /* Increased height */
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            background: rgba(255, 255, 255, 0.3); /* Less transparency */
            backdrop-filter: blur(5px); /* Reduced blur */
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            cursor: pointer;
        }

        /* Hover effect */
        .action-box:hover {
            transform: scale(1.08);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        /* Box links */
        .action-box a {
            text-decoration: none;
            color: white;
            font-size: 30px;  /* Increased font size */
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="wrapper">
    <nav class="nav">
        <div class="nav-logo">
            <p>Student Management</p>
        </div>
        <div class="nav-menu" id="navMenu">
            <ul>
                <li><a href="welcome.php" class="link active">Home</a></li>
                <li><a href="add_student.php" class="link">Add Student</a></li>
                <li><a href="search_student.php" class="link">Search Students</a></li> <!-- Fixed Link -->
            </ul>
        </div>
        <div class="nav-button">
            <a href="logout.php" class="btn">Logout</a>
        </div>
    </nav>

    <!-- New Larger Boxes for Add & Search Student -->
    <div class="action-container">
        <div class="action-box">
            <a href="add_student.php">Add Student</a>
        </div>
        <div class="action-box">
            <a href="search_student.php">Search Students</a> <!-- Fixed Link -->
        </div>
    </div>
</div>

<?php
$conn->close();
?>

</body>
</html>

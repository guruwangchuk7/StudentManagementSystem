<?php
$servername = "localhost";
$username = "root";
$password = "9099";
$dbname = "majorprojectdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID is provided
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Debugging: Log received ID
    error_log("Deleting student with ID: " . $id);

    // Prepare delete statement
    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $id);                                                                                                            

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Error deleting record: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request!";
}

$conn->close();
?>

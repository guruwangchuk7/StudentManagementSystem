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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure input data is not empty and sanitize
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);
    
    // Insert student data into the database
    $sql = "INSERT INTO students (first_name, last_name, dob, gender, address, phone, email, course) 
            VALUES ('$first_name', '$last_name', '$dob', '$gender', '$address', '$phone', '$email', '$course')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Student added successfully!'); window.location.href='welcome.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link rel="stylesheet" href="addstyle.css">
    <style>
        .back-button {
            position: absolute;
            top: 30px;
            left: 45px;
            background-color: #5cb85c;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
        }
        .back-button:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>
    <a href="welcome.php" class="back-button">Back</a>
    <div class="wrapper">
        <h2>Student Registration</h2>
        <form action="add_student.php" method="post">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" required>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" id="dob" name="dob" required>
            </div>
            <div class="form-group">
                <label>Gender</label>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="gender" value="Male" required> Male
                    </label>
                    <label>
                        <input type="radio" name="gender" value="Female" required> Female
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="course">Course</label>
                <select id="course" name="course" required>
                    <option value="Computer Science">Computer Science</option>
                    <option value="Business Administration">Business Administration</option>
                    <option value="Mechanical Engineering">Mechanical Engineering</option>
                    <option value="Psychology">Psychology</option>
                    <option value="Biotechnology">Biotechnology</option>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" value="Add Student">
            </div>
        </form>
    </div>
</body>
</html>

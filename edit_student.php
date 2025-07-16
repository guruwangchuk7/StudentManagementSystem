<?php
$servername = "localhost";
$username = "root";
$password = "9099";
$dbname = "majorprojectdb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$student = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch student details (using correct column names)
    $stmt = $conn->prepare("SELECT first_name, last_name, dob, gender, address, phone, email, course FROM students WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();

    if (!$student) {
        echo "Student not found!";
        exit;
    }
} else {
    echo "No student ID provided.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $dob = $_POST["dob"];
    $gender = $_POST["gender"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $course = $_POST["course"];

    // Corrected update query with proper column names
    $stmt = $conn->prepare("UPDATE students SET first_name=?, last_name=?, dob=?, gender=?, address=?, phone=?, email=?, course=? WHERE id=?");
    $stmt->bind_param("ssssssssi", $first_name, $last_name, $dob, $gender, $address, $phone, $email, $course, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Student details updated successfully!'); window.location.href = 'search_student.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 50%;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }
        input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background: #5cb85c;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #4cae4c;
        }
        .back-button {
            display: inline-block;
            margin-top: 10px;
            padding: 10px;
            background: #337ab7;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-button:hover {
            background: #286090;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Student</h2>
        <?php if ($student): ?>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="first_name" value="<?php echo $student['first_name']; ?>" required>
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="last_name" value="<?php echo $student['last_name']; ?>" required>
            </div>
            <div class="form-group">
                <label>Date of Birth</label>
                <input type="date" name="dob" value="<?php echo $student['dob']; ?>" required>
            </div>
            <div class="form-group">
                <label>Gender</label>
                <select name="gender" required>
                    <option value="Male" <?php if ($student['gender'] == "Male") echo "selected"; ?>>Male</option>
                    <option value="Female" <?php if ($student['gender'] == "Female") echo "selected"; ?>>Female</option>
                </select>
            </div>
            <div class="form-group">
                <label>Address</label>
                <input type="text" name="address" value="<?php echo $student['address']; ?>" required>
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="tel" name="phone" value="<?php echo $student['phone']; ?>" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?php echo $student['email']; ?>" required>
            </div>
            <div class="form-group">
                <label>Course</label>
                <input type="text" name="course" value="<?php echo $student['course']; ?>" required>
            </div>
            <input type="submit" value="Save">
        </form>
        <?php else: ?>
        <p>Student not found!</p>
        <?php endif; ?>
        <a href="search_student.php" class="back-button">Cancel</a>
    </div>
</body>
</html>

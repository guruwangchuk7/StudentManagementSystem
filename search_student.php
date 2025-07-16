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

// Handle AJAX request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);

    // Search query
    $sql = "SELECT * FROM students WHERE first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR email LIKE '%$search%'";
    $result = $conn->query($sql);

    $students = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
    }

    // Return JSON response
    echo json_encode($students);
    exit();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Student</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 80%;
            max-width: 900px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            position: relative;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        input[type="text"] {
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
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #4cae4c;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background: #fff;
            display: none;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background: #5cb85c;
            color: white;
        }
        .error-message {
            color: red;
            display: none;
        }
        .action-buttons button {
            margin: 5px;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
        }
        .edit-btn {
            background: #f0ad4e;
            color: white;
        }
        .delete-btn {
            background: #d9534f;
            color: white;
        }
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
    <script>
        function searchStudent(event) {
            event.preventDefault();
            let searchValue = document.getElementById("search").value;
            let table = document.getElementById("resultTable");
            let errorMessage = document.getElementById("errorMessage");
            if (searchValue.trim() === "") {
                errorMessage.style.display = "block";
                errorMessage.textContent = "Please enter a name or email to search.";
                table.style.display = "none";
                return;
            }
            errorMessage.style.display = "none";
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "search_student.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    let response = JSON.parse(xhr.responseText);
                    let resultBody = document.getElementById("resultBody");
                    resultBody.innerHTML = "";
                    if (response.length === 0) {
                        errorMessage.style.display = "block";
                        errorMessage.textContent = "No results found!";
                        table.style.display = "none";
                    } else {
                        table.style.display = "table";
                        response.forEach(student => {
                            let row = `<tr>
                                <td>${student.first_name}</td>
                                <td>${student.last_name}</td>
                                <td>${student.email}</td>
                                <td>${student.course}</td>
                                <td class="action-buttons">
                                    <button class="edit-btn" onclick="editStudent(${student.id})">Edit</button>
                                    <button class="delete-btn" onclick="deleteStudent(${student.id})">Delete</button>
                                </td>
                            </tr>`;
                            resultBody.innerHTML += row;
                        });
                    }
                }
            };
            xhr.send("search=" + encodeURIComponent(searchValue));
        }
        function editStudent(id) {
            window.location.href = `edit_student.php?id=${id}`;
        }
        function deleteStudent(id) {
            if (confirm("Are you sure you want to delete this student?")) {
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "delete_student.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        alert("Student deleted successfully!");
                        searchStudent(event);
                    }
                };
                xhr.send("id=" + id);
            }
        }
    </script>
</head>
<body>
    <div>
        <a href="welcome.php" class="back-button">Back</a>
    </div>
    <div class="container">
        <h2>Search Student</h2>
        <form onsubmit="searchStudent(event)">
            <div class="form-group">
                <input type="text" id="search" name="search" placeholder="Enter name or email..." required>
            </div>
            <div class="form-group">
                <input type="submit" value="Search">
            </div>
        </form>
        <p id="errorMessage" class="error-message"></p>
        <table id="resultTable">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Course</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="resultBody"></tbody>
        </table>
    </div>
</body>
</html>

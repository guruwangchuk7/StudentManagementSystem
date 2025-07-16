<?php
 session_start();
 $servername = "localhost";
 $username = "root";
 $password = "9099";
 $dbname = "majorprojectdb";
 
 $conn = new mysqli($servername, $username, $password, $dbname);
 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }
 
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $email = mysqli_real_escape_string($conn, $_POST['email']);
     $password = $_POST['password'];
 
     $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
     $result = $conn->query($sql);
 
     if ($result->num_rows > 0) {
         $user = $result->fetch_assoc();
         if (password_verify($password, $user['password'])) {
             $_SESSION['user_id'] = $user['id'];
             $_SESSION['firstname'] = $user['firstname'];
             header("Location: welcome.php");
             exit();
         } else {
             echo "Incorrect password!";
         }
     } else {
         echo "No user found with this email.";
     }
 }
 
 $conn->close();
 ?>
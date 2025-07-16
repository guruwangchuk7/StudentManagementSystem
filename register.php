<?php
 $servername = "localhost";
 $username = "root";
 $password = "9099";
 $dbname = "majorprojectdb";
 
 $conn = new mysqli($servername, $username, $password, $dbname);
 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }
 
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
     $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
     $email = mysqli_real_escape_string($conn, $_POST['email']);
     $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
 
     $check_email_sql = "SELECT * FROM users WHERE email='$email'";
     $result = $conn->query($check_email_sql);
 
     if ($result->num_rows > 0) {
         echo "This email is already taken.";
     } else {
         $sql = "INSERT INTO users (firstname, lastname, email, password) 
                 VALUES ('$firstname', '$lastname', '$email', '$password')";
         if ($conn->query($sql) === TRUE) {
            header("Location: index.html?registered=true");
         } else {
            echo "Error: " . $conn->error;
         }
     }
 }
 
 $conn->close();
 ?>
<?php
 // Database connection details
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
 
 // SQL query to create the 'students' table
 $sql = "CREATE TABLE IF NOT EXISTS students (
     id INT AUTO_INCREMENT PRIMARY KEY,
     first_name VARCHAR(50) NOT NULL,
     last_name VARCHAR(50) NOT NULL,
     email VARCHAR(100) NOT NULL,
     phone VARCHAR(20),
     address TEXT
 )";
 
 // Execute the query
 if ($conn->query($sql) === TRUE) {
     echo "Table 'students' created successfully!";
 } else {
     echo "Error creating table: " . $conn->error;
 }
 
 // Close the connection
 $conn->close();
 ?>
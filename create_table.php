<?php
 /*// Database connection parameters
 $servername = "localhost";
 $username = "root"; // Your MySQL username
 $password = "9099"; // Your MySQL password
 $dbname = "majorprojectdb"; // The name of the database
 
 // Create connection
 $conn = new mysqli($servername, $username, $password);
 
 // Check connection
 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }
 
 // SQL to create the database if not exists
 $sql_create_db = "CREATE DATABASE IF NOT EXISTS $dbname";
 
 // Execute query to create the database
 if ($conn->query($sql_create_db) === TRUE) {
     echo "Database created successfully or already exists.\n";
 } else {
     echo "Error creating database: " . $conn->error;
 }
 
 // Select the created database
 $conn->select_db($dbname);
 

 // SQL to create students table
 $sql_create_students_table = "
     CREATE TABLE IF NOT EXISTS students (
         id INT AUTO_INCREMENT PRIMARY KEY,
         first_name VARCHAR(50) NOT NULL,
         last_name VARCHAR(50) NOT NULL,
         email VARCHAR(100) NOT NULL UNIQUE,
         phone VARCHAR(20) NOT NULL,
         address TEXT NOT NULL
     );
 ";
 
 // Execute queries to create tables
 if ($conn->query($sql_create_users_table) === TRUE) {
     echo "Users table created successfully or already exists.\n";
 } else {
     echo "Error creating users table: " . $conn->error;
 }
 
 if ($conn->query($sql_create_students_table) === TRUE) {
     echo "Students table created successfully or already exists.\n";
 } else {
     echo "Error creating students table: " . $conn->error;
 }
 
 // Close connection
 $conn->close();
 ?>
 */
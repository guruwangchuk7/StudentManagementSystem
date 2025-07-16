<?php
 // select_data.php
 
 $servername = "localhost";
 $username = "root";
 $password = "9099";  // Empty password
 $dbname = "majorprojectdb"; // Database name
 
 // Create connection
 $conn = new mysqli($servername, $username, $password, $dbname);
 
 // Check connection
 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }
 
 $sql = "SELECT user_name, pass_word FROM login_data";  // Only select existing columns
 $result = $conn->query($sql);
 
 // Display the data
 if ($result->num_rows > 0) {
     echo "<h2>Data from login_data table:</h2>";
     echo "<table border='1'><tr><th>Username</th><th>Password</th></tr>";
     
     while($row = $result->fetch_assoc()) {
         echo "<tr><td>" . $row["user_name"]. "</td><td>" . $row["pass_word"]. "</td></tr>";
     }
     echo "</table>";
 } else {
     echo "0 results";
 }
 
 $conn->close();
 ?>
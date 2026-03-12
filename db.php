<?php
// db.php - Database connection

$host = "localhost";      
$db_name = "cmcs_db";      
$username = "root";        
$password = "";            

// Create connection
$conn = new mysqli($host, $username, $password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully"; // Uncomment to test connection
?>
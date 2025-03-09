<?php
$host = "localhost";  // XAMPP default host
$user = "root";       // Default MySQL username in XAMPP
$pass = "";           // Default MySQL password (empty in XAMPP)
$dbname = "hostelconnect"; // Your database name

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

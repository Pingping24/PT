<?php
// Database connection credentials
$servername = "127.0.0.1";
$username = "mariadb";
$password = "mariadb";
$dbname = "mariadb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>


<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zoo_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // Log the error to a file and display a generic message
    error_log("Connection failed: " . $conn->connect_error, 3, "error_log.txt");
    die("Connection failed. Please try again later.");
}
?>

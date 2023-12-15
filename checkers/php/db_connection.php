<?php
//SET CONNECTION PAGE - IT IS THE CONNECTION WITH THE DATABASE
//ini_set('display_errors', 1); // Turn off in production
//error_reporting(E_ALL); // Turn off in production

$servername = "localhost"; // Replace with your servername
$username = "root";  // Replace with your username
$password = "";  // Replace with your MySQL password
$database = "game";  // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the database is selected
if (!$conn->select_db($database)) {
    die("Failed to select database: " . $conn->error);

}

$conn->set_charset("utf8mb4");
?>




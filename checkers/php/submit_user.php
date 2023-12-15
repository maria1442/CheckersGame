<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection details
include 'db_connection.php';

//Form Data Handling:
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['Name'];
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
//Password Check
    if ($password !== $confirmPassword) {
        die("Passwords do not match.");
    }
//Password Hashing:
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
//Database Insertion:
    $stmt = $conn->prepare("INSERT INTO users (Name,user_name, email,  password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name,  $user_name, $email, $hashedPassword);

    if ($stmt->execute()) {
        header("Location: ../php/login.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

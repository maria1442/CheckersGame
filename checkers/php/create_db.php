<?php
//File to Create Database (game) and tables user and game_results
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection details
include 'db_connection.php';

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS game";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully\n";
} else {
    echo "Error creating database: " . $conn->error . "\n";
}

// selects the database
$conn->select_db('game');

// SQL query to create users table
$sql1 = "CREATE TABLE IF NOT EXISTS users (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  Name VARCHAR(255) NOT NULL,
  user_name VARCHAR(255) NOT NULL UNIQUE,
  email VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  wins INT(11) DEFAULT 0,
  win_time VARCHAR(5) DEFAULT NULL,
  losses int(11) DEFAULT 0,
  games_played int(11) DEFAULT 0,
  total_time_played int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

// Execute the query to create the users table
if ($conn->query($sql1) === TRUE) {
    echo "Table users created successfully\n";
} else {
    echo "Error creating table: " . $conn->error . "\n";
}

// SQL query to create  game_results table

$sql2 = "CREATE TABLE IF NOT EXISTS game_results (
    game_id int(11) NOT NULL AUTO_INCREMENT,
    winner varchar(255) NOT NULL,
    loser varchar(255) NOT NULL,
    win_time varchar(8) NOT NULL,
    PRIMARY KEY (game_id)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

// Execute the query to create the  game_results table
if ($conn->query($sql2) === TRUE) {
    echo "Table game_results created successfully\n";
} else {
    echo "Error creating table: " . $conn->error . "\n";
}

$conn->close();
?>

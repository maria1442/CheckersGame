<?php
// Database connection details
include 'db_connection.php';

if (isset($_GET['winnerUserName']) && isset($_GET['winTimeSeconds'])) {
    $winnerUserName = $_GET['winnerUserName'];
    $winTimeSeconds = $_GET['winTimeSeconds']; // Assuming the win time is in seconds

    // SQL to update the winner's total wins and check for best win time (assuming win_time is stored in seconds)
    $sql = "UPDATE users SET wins = wins + 1, win_time = IF(win_time IS NULL OR win_time > ?, ?, win_time) WHERE user_name = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("iis", $winTimeSeconds, $winTimeSeconds, $winnerUserName);
      

        // Execute the statement
        if ($stmt->execute()) {
            echo "Winner updated successfully.";
        } else {
            echo "Error updating winner: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>

<?php
// Database connection details
include 'db_connection.php';

if (isset($_GET['winnerName'], $_GET['loserName'], $_GET['winTime'])) {
    $winnerName = $_GET['winnerName'];
    $loserName = $_GET['loserName'];
    $winTime = $_GET['winTime'];

    // Start a transaction
    $conn->begin_transaction();

    try {
        // 1. Insert the game result
        $stmt = $conn->prepare("INSERT INTO game_results (winner, loser, win_time) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $winnerName, $loserName, $winTime);
        if (!$stmt->execute()) {
            throw new Exception($stmt->error);
        }
        $stmt->close();

        // 2. Update the winner's record
        $stmt = $conn->prepare("UPDATE users SET wins = wins + 1, games_played = games_played + 1, total_time_played = total_time_played + ? WHERE user_name = ?");
        $stmt->bind_param("is", $winTime, $winnerName);
        if (!$stmt->execute()) {
            throw new Exception($stmt->error);
        }
        $stmt->close();

        // 3. Update the loser's record
        $stmt = $conn->prepare("UPDATE users SET games_played = games_played + 1, total_time_played = total_time_played + ? WHERE user_name = ?");
        $stmt->bind_param("is", $winTime, $loserName);
        if (!$stmt->execute()) {
            throw new Exception($stmt->error);
        }
        $stmt->close();

        // Commit the transaction
        $conn->commit();
        echo "Game and user stats updated successfully.";
    } catch (Exception $e) {
        // An error occurred, roll back the transaction
        $conn->rollback();
        echo "An error occurred: " . $e->getMessage();
    }
}

$conn->close();
?>

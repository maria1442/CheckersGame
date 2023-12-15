<?php
session_start();

// Assuming player 1 is the user and player 2 is the opponent
$userName = $_SESSION['name'];
$opponentName = $_SESSION['opponent'];

// Check if the session variable 'currentPlayer' is set
if (!isset($_SESSION['currentPlayer'])) {
    // If not set, it means it's the first move, so set the current player to the user
    $_SESSION['currentPlayer'] = $userName;
} else {
    // If set, switch the current player to the other player
    $_SESSION['currentPlayer'] = ($_SESSION['currentPlayer'] === $userName) ? $opponentName : $userName;
}

// Return the current player in the response
echo json_encode(['success' => true, 'currentPlayer' => $_SESSION['currentPlayer']]);
?>

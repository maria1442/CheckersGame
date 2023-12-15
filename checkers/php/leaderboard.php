<?php
//PHP Tags and Error Reporting
/*ini_set('display_errors', 1);
error_reporting(E_ALL);
*/
session_start(); // Corrected: session_start should be at the beginning

// Database connection details
include 'db_connection.php';
//  If a user is logged in ($_SESSION['user_name'] is set), fetches game results involving the user.
if (isset($_SESSION['user_name'])) {
    $user_name = $_SESSION['user_name'];

    //fetch game results where the logged-in user is either the winner or the loser
    $game_results_query = "SELECT game_id, winner, loser, win_time FROM game_results WHERE winner = ? OR loser = ? ORDER BY game_id DESC";
    
   
  $stmt = $conn->prepare($game_results_query);
  $stmt->bind_param("ss", $user_name, $user_name);
  $stmt->execute();
  $userGamesResult = $stmt->get_result();
}

//Fetches a list of users ordered by their wins and total playtime.  user joined with the game_results table
//u.Name: The name of the user.
//u.user_name: The username of the user.
//u.wins: The number of games the user has won.
//--------- Subquery for Latest Win Time:
   // FROM game_results gr: The subquery selects from the game_results table.

$leaderboardQuery = "SELECT u.Name, u.user_name, u.wins, 
(SELECT gr.win_time FROM game_results gr WHERE gr.winner = u.user_name OR gr.loser = u.user_name ORDER BY gr.game_id DESC LIMIT 1) AS latest_win_time 
FROM users u ORDER BY u.wins DESC, u.total_time_played ASC";
$leaderboardResult = $conn->query($leaderboardQuery);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LeaderBoard</title>
    <link rel="icon" href="bb.png" type="image/png">
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        .btn:hover {
            background-color: #ffffff;
            color: #B1102B;
        }

        .active-button {
            color: #ffffff !important;
            background-color: #B1102B !important;
            border: 2px solid #ffffff !important;
        }

        main {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding-top: 15vh;
            /* Adjust this value to move content higher */

        }

        .user-info {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .welcome-message {
            margin: 0;
            color: white;
        }

        .button1 {
            font-weight: 800px;
            padding: 10px 15px;
            margin: 5px;
            color: #b1102b;
            background-color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            top: 20px;
            font-size: 16px;
            text-decoration: none;
            border: 2px solid #b1102b;
        }

        .button2,
        .button3 {
            font-family: Roboto-Medium, Helvetica;
            font-weight: 500;
            padding: 10px 15px;
            margin: 5px;
            color: #ffffff;
            background-color: #b1102b;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            border: 2px solid #b1102b;
            transition: background-color 0.3s, color 0.3s;
        }
    </style>
</head>

<body>

    <header>

        <!--Nav Bar-->
        <nav>

            <div class="navbar">
                <div class="logo-container">
                    <img class="element" src="bb.png" alt="BBLogo">
                </div>
                <div class="auth-buttons">
                    <?php if (!isset($_SESSION['user_name'])): ?>
                    <!-- Show these buttons only if the user is not logged in -->
                    <a href="../html/signUp.html" class="button1" id="signInForm">Sign Up</a>
                    <a href="../php/login.php" class="button2" id="login">Log In</a>
                    <?php else: ?>
                    <!-- Container for welcome message and logout button -->
                    <div class="user-info">
                        <p class="welcome-message">Welcome,
                            <?php echo htmlspecialchars($_SESSION['name']); ?>
                        </p>
                        <a href="logout.php" class="button3">Logout</a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="box">
                <div class="rectangle">
                    <ul>
                        <li><a href="../php/main.php">Home</a></li>
                        <li><a href="../php/help.php">How To Play</a></li>
                        <li><a href="../php/leaderboard.php" class="active">>Leaderboard</a></li>
                        <li><a href="../php/contact.php">Contact</a></li>
                    </ul>
                    </ul>


                </div>
            </div>

        </nav>


    </header>

    <!-- Game Instructions Box-->
    <main>

        <section class="leaderboard">
            <h2>LEADERBOARD</h2>
            <table>
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Name</th>
                        <th>username</th>
                        <th>Games Won</th>
                        <th>Latest Win time</th>

                        <!--<th>Games Played</th>
                        <th>Time Played</th>
                            -->
                    </tr>
                </thead>
                <tbody>
                    <!--Leaderboard Display: Shows a table of players ranked by their performance-->
                    <?php if ($leaderboardResult->num_rows > 0) {
        // output data of each row
        $rank = 1;
        while($row = $leaderboardResult->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $rank++ . "</td>";
            echo "<td>" . htmlspecialchars($row['Name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['user_name']) . "</td>";
            echo "<td>" . $row['wins'] . "</td>";
            echo "<td>" . htmlspecialchars($row['latest_win_time']) . "</td>";  // Display win_time

            //echo "<td" . $row['win_time'] . "</td>";
            // Add other columns like 'Games Played', 'Time Played' if available in your database
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No data found</td></tr>";
    }
    ?>
                </tbody>


            </table>
        </section>

        <!--Match History: For logged-in users, displays their match history.-->
        <?php if (isset($_SESSION['user_name'])): ?>
        <section class="leaderboard">
            <h2>Match History</h2>
            <table>
                <thead id="match-history-table">
                    <tr>
                        <th>Match ID</th>
                        <th>Winner</th>
                        <th>Loser</th>
                        <th>Win Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                if ($userGamesResult->num_rows > 0) {
                    while ($row = $userGamesResult->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['game_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['winner']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['loser']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['win_time']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No data found</td></tr>"; // Adjust colspan as per your table columns
                }
                ?>
                </tbody>
            </table>
        </section>
        <?php endif; ?>


    </main>

    <script>
        // JavaScript to show/hide Player 2's name input based on player mode
        const playerModeRadios = document.querySelectorAll('input[name="playerMode"]');
        const player2NameContainer = document.getElementById('player2NameContainer');

        playerModeRadios.forEach(radio => {
            radio.addEventListener('change', () => {
                player2NameContainer.style.display = radio.value === 'multiPlayer' ? 'block' : 'none';
            });

            // Get the button by its ID
            document.getElementById('signup2').addEventListener('click', function () {
                // Redirect to the sign-up page
                window.location.href = 'signUp_copy.html';
            });

            document.getElementById('login1').addEventListener('click', function () {
                // Redirect to the sign-up page
                window.location.href = 'login_copy.html';
            });

            document.getElementById('signup2').addEventListener('click', function () {
                // Redirect to the sign-up page
                window.location.href = 'signUp_copy.html';
            });

        });
    
        function redirectToGame() {
            // Get the selected board size, player mode, and player names
            const selectedBoardSize = document.getElementById('gameMode').value;
            const selectedPlayerMode = document.querySelector('input[name="playerMode"]:checked').value;
            const player1Name = encodeURIComponent(document.getElementById('player1Name').value);
            const player2Name = selectedPlayerMode === 'multiPlayer' ? encodeURIComponent(document.getElementById('player2Name').value) : '';

            // Construct the query string
            let queryString = `?player1Name=${player1Name}`;
            if (player2Name) queryString += `&player2Name=${player2Name}`;

            // Redirect based on the selected board size and player mode
            if (selectedBoardSize === '8x8') {
                window.location.href = `../php/game_eight.php${queryString}`;
            } else if (selectedBoardSize === '10x10') {
                window.location.href = `../php/game_ten.php${queryString}`;
            }

            // Return false to prevent the form from submitting
            return false;
        }


    </script>


    <?php $conn->close(); ?>



</body>

</html>
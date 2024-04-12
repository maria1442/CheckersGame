<?php
session_start();

// Database connection details
include 'db_connection.php';

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_name'] = $user['user_name'];
    $_SESSION['name'] = $user['Name'];
    header('Location: ../php/main.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomePage</title>
    <link rel="icon" href="bb.png" type="image/png">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="script.js"></script>
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
            padding-top: 7vh;

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
            position: absolute;
            right: 40px; /* Adjust this value as needed */
            top: 20px;
        }

        .button2{
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
            position: absolute;
            right: 145px; /* Adjust this value as needed */
            top: 20px;
        }

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

        .user-info {
    position: absolute;
    top: 20px;
    right: 40px; /* Adjust this value as needed */
    display: flex;
    align-items: center;
 
         
            gap: 15px;
}

.welcome-message {
    margin-right: 10px; /* Adjust this value as needed */
    margin: 0;
            color: white;
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
                    <?php if (!isset($_SESSION['name'])): ?>
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
                        <li><a href="#" class="active">>Home</a></li>
                        <li><a href="../php/help.php">How To Play</a></li>
                        <li><a href="../php/leaderboard.php">Leaderboard</a></li>
                        <li><a href="../php/contact.php">Contact</a></li>
                    </ul>


                </div>
            </div>

        </nav>


    </header>

    <!-- Introduction to the game -->
    <main>

        <div class="game-intro">
            <h1>The Dogs CheckersGame</h1>
            <br>
            <p style="text-align: center; color:white; font-size: 20px; ">Are you ready to play? Choose the the game
                mood <br> below to play and choose your favorite rules</p>


            <?php
        $gameMode = isset($_GET['gameMode']) ? $_GET['gameMode'] : '';
        $playerMode = isset($_GET['playerMode']) ? $_GET['playerMode'] : '';

        if ($playerMode === 'single') {
            // Display single player configuration
            echo '<div id="onePlayerConfig" style="text-align: center; padding: 20px;">';
            echo '</div>';
        } else if ($playerMode === 'multi') {
            // Display multi-player configuration
            echo '<div id="twoPlayerConfig" style="text-align: center; padding: 20px;">';
         
            echo '</div>';
        }
        ?>

            <form action="game.php" method="get" onsubmit="return redirectToGame()">
                <input type="hidden" name="gameMode" value="<?php echo $gameMode; ?>">
                <input type="hidden" name="playerMode" value="<?php echo $playerMode; ?>">

                <!-- Rest of your HTML form -->
            </form>


            <!-- Player Mode Selection -->
            <section class="player-mode-selection" style="text-align: center; padding: 20px;">
                <!-- One Player Button -->
                <button type="button" id="singlePlayerButton" class="player-mode-button" style="font-weight: 800;
    padding: 10px 15px;
    margin: 5px;
    color: #B1102B;
    background-color: #ffffff;
    border: 2px solid #B1102B;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    text-decoration: none;">One Player</button>
                <!-- Two Player Button -->
                <button type="button" id="multiPlayerButton" class="player-mode-button" style="font-weight: 800;
    padding: 10px 15px;
    margin: 5px;
    color: #B1102B;
    background-color: #ffffff;
    border: 2px solid #B1102B;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    text-decoration: none;">Two Player</button>
            </section>


            <!-- One Player Configuration (hidden by default) -->
            <div id="onePlayerConfig" style="display: none; text-align: center; padding: 20px;">
                <!-- Player 1 Name -->
                <div style="margin: auto; width: fit-content;">
                    <label for="player1NameSingle" style="margin-right: 10px;color:#ffffff; font-weight: medium">Player
                        1 Name:</label>
                    <input type="text" name="player1Name" id="player1NameSingle"
                        style="padding: 8px; border-radius: 5px; border: 1px solid #B1102B;"
                        value="<?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : ''; ?>">
                </div>


                <!-- Select Board Size -->
                <div style="margin: auto; width: fit-content; margin-top: 10px;">
                    <label for="gameModeSingle" style="margin-right: 10px;color:#ffffff; font-weight: medium"">Select Board Size:</label>
    <select name=" gameMode" id="gameModeSingle" style="padding: 8px; border-radius: 5px; border: 1px solid #B1102B;">
                        <option value="8x8">8x8</option>
                        <option value="10x10">10x10</option>
                        </select>
                </div>
                <br>

                <button type="button" id="startSinglePlayerGameButton" onclick="redirectToGame('single')"
                    style="font-weight: 800; padding: 10px 15px; color: #ffffff; background-color: #B1102B; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; text-decoration: none;">Start
                    Game</button>
            </div>


            <!-- Two Player Configuration (hidden by default) -->
            <div id="twoPlayerConfig" style="display: none; text-align: center; padding: 20px;">
                <!-- Player 1 Name -->
                <div style="margin: auto; width: fit-content;">
                    <label for="player1NameMulti" style="margin-right: 10px;color:#ffffff; font-weight: medium">Player 1
                        Name:</label>
                    <input type="text" name="player1Name" id="player1NameMulti"
                        style="padding: 8px; border-radius: 5px; border: 1px solid #B1102B;"
                        value="<?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : ''; ?>">>
                </div>

                <!-- Player 2 Name -->
                <div style="margin: auto; width: fit-content; margin-top: 10px;">
                    <label for="player2NameMulti" style="margin-right: 10px;color:#ffffff; font-weight: medium">Player 2
                        Name:</label>
                    <input type="text" name="player2Name" id="player2NameMulti"
                        style="padding: 8px; border-radius: 5px; border: 1px solid #B1102B;">
                </div>

                <div style="margin: auto; width: fit-content; margin-top: 10px;">
                    <label for="gameModeMulti" style="margin-right: 10px;color:#ffffff; font-weight: medium">Select
                        Board Size:</label>
                    <select name="gameMode" id="gameModeMulti"
                        style="padding: 8px; border-radius: 5px; border: 1px solid #B1102B;">
                        <option value="8x8">8x8</option>
                        <option value="10x10">10x10</option>
                    </select>
                </div>
                <br>

                <button type="button" id="startMultiPlayerGameButton" onclick="redirectToGame('multi')"
                    style="font-weight: 800; padding: 10px 15px; color: #ffffff; background-color: #B1102B; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; text-decoration: none;">Start
                    Game</button>
            </div>

    </main>

    <script>
        document.getElementById('singlePlayerButton').addEventListener('click', function () {
            activateButton(this); // Highlight the selected button
            // Show the one player configuration
            document.getElementById('onePlayerConfig').style.display = 'block';
            // Hide the two player configuration
            document.getElementById('twoPlayerConfig').style.display = 'none';
        });

        document.getElementById('multiPlayerButton').addEventListener('click', function () {
            activateButton(this); // Highlight the selected button
            // Show the two player configuration
            document.getElementById('twoPlayerConfig').style.display = 'block';
            // Hide the one player configuration
            document.getElementById('onePlayerConfig').style.display = 'none';
        });

        function activateButton(selectedButton) {
            // Remove active class from both buttons
            document.getElementById('singlePlayerButton').classList.remove('active-button');
            document.getElementById('multiPlayerButton').classList.remove('active-button');

            // Add active class to the selected button
            selectedButton.classList.add('active-button');
        }

        function redirectToGame(mode) {
            var selectedBoardSize = mode === 'single' ? document.getElementById('gameModeSingle').value : document.getElementById('gameModeMulti').value;
            var player1Name = mode === 'single' ? encodeURIComponent(document.getElementById('player1NameSingle').value) : encodeURIComponent(document.getElementById('player1NameMulti').value);
            var queryString = `?gameMode=${selectedBoardSize}&player1Name=${player1Name}`;

            if (mode === 'multi') {
                var player2Name = encodeURIComponent(document.getElementById('player2NameMulti').value);
                queryString += `&player2Name=${player2Name}`;
            }

            var gamePage = selectedBoardSize === '8x8' ? '../php/game_eight.php' : 'game_ten.php';
            window.location.href = gamePage + queryString;
        }
    </script>





</body>

</html>
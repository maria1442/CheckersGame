<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>How To Play</title>
    <link rel="stylesheet" href="../css/styles.css" />
    <link rel="icon" href="bb.png" type="image/png" />
    <style>
    

        .resize-gif {
            width: 500px;
            height: 300px;
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
    <?php session_start(); ?>

    <header>
        <!--Nav Bar-->
        <nav>
            <div class="navbar">
                <div class="logo-container">
                    <img class="element" src="bb.png" alt="BBLogo" />
                </div>
                <div class="auth-buttons">
                    <?php if (!isset($_SESSION['name'])): ?>
                    <!-- PHP Session Start -->
                    <!-- Show these buttons only if the user is not logged in -->
                    <a href="../html/signUp.html" class="button1" id="signInForm">Sign Up</a>
                    <a href="../php/login.php" class="button2" id="login">Log In</a>
                    <?php else: ?>
                    <!-- Container for welcome message and logout button -->
                    <div class="user-info">
                        <p class="welcome-message">
                            Welcome,
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
                        <li><a href="../php/help.php" class="active">>How To Play</a></li>
                        <li><a href="../php/leaderboard.php">Leaderboard</a></li>
                        <li><a href="../php/contact.php">Contact</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="team-container">
        <h2 class="team-title">How to Play the Game: THE GUIDE!</h2>
        <section>
            <h3 class="team-description">
                Objective: Capture all of your opponent's pieces or block them from
                moving.
            </h3>
            <img src="../help_images/game.gif" alt="Description of the GIF" class="resize-gif" />
        </section>
        <br />

        <br />

        <hr />

        <br />
        <section>
            <h3>Starting the Game:</h3>
            <div>
                <img src="../help_images/8x8.png" alt="8x8 Game Board" style="width: 100%; max-width: 300px" />
                <img src="../help_images/10x10.png" alt="10x10 Game Board" style="width: 100%; max-width: 300px" />
            </div>
            <p>
                The game board consists of a 10x10 or 8x8 grid with alternating
                colors. Each player starts with 20 (10x10) or 12 (8x8) pieces
                positioned on the dark squares of the first four rows closest to them.
            </p>
        </section>
        <br />
        <hr />
        <br />
        <section>
            <h3>Playing the Game:</h3>
            <ul>
                <li>
                    Players alternate turns, starting with Player 1 or the logged-in
                    player.
                </li>
                <li>
                    Move a piece diagonally to an adjacent unoccupied dark square.
                </li>
                <img src="../help_images/redarrow.png" alt="Piece Movement" style="width: 200px; max-width: 600px" />

                <li>
                    Capture an opponent's piece by jumping over it to an empty square
                    behind it.
                </li>

                <li>
                    If a piece reaches the farthest row from the player, it becomes a
                    King and can move both forward and backward.
                </li>
                <img src="../help_images/king2.png" alt="King Piece" style="width: 200px; max-width: 600px" />
                <img src="../help_images/king.png" alt="King Piece" style="width: 200px; max-width: 600px" />

                <li>
                    The game continues until a player has no more moves or pieces.
                </li>
            </ul>
        </section>
        <br />
        <hr />
        <br />
        <section>
            <h3>Winning the Game:</h3>
            <img src="../help_images/win.png" alt="Winning Position" style="width: 100%; max-width: 600px" />
            <p>
                A player wins by capturing all of the opponent's pieces or blocking
                them so they cannot move.
            </p>
        </section>
        <br>
        <hr>
        <br>
        <section>
            <h3>Tips:</h3>
            <ul>
                <li>Plan ahead and think strategically about your moves.</li>
                <li>
                    Aim to control the center of the board to give your pieces more
                    mobility.
                </li>
                <li>Be cautious with your King pieces as they are valuable.</li>
            </ul>
        </section>
        <br />
        <hr />
        <br />
    </div>
</body>

</html>
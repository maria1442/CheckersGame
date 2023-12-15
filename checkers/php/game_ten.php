<?php
session_start();

// Database connection details
include 'db_connection.php';
$player1Name = isset($_GET['player1Name']) ? $_GET['player1Name'] : '';
$player2Name = isset($_GET['player2Name']) ? $_GET['player2Name'] : '';

?>

<!DOCTYPE html>
<html>

<head>
  <title>10x10 Checkers Game</title>
  <link rel="icon" href="bb.png" type="image/png">
  <link rel="stylesheet" href="../css/styles.css">

  <style>
    input[type="color"] {
      width: 40px;
      height: 40px;
      -webkit-appearance: none;
      border: none;
      border-radius: 50%;
      cursor: pointer;
      padding: 0;
      background: none;
    }

    input[type="color"]::-webkit-color-swatch-wrapper {
      padding: 0;
    }

    input[type="color"]::-webkit-color-swatch {
      border: 2px solid #964B00;
      border-radius: 50%;
      box-sizing: border-box;
    }


    #player1PieceCount,
    #player2PieceCount,
    #player1Time,
    #player2Time {
      margin-bottom: 5px;
    }



    .game-container {
      display: flex;
      justify-content: center;
      align-items: flex-start;
    }


    body {
      font-family: Arial, sans-serif;
      background-color: #f7f7f7;
      text-align: center;
      margin: 0;
      padding: 0;
    }

    h1 {
      color: #333;
      margin-top: 20px;
    }

    h2 {
      color: #555;
      font-size: 1.2em;
      margin-bottom: 20px;
    }

    #gameCanvas {
      border: 5px solid #333;
    }


    #currentPlayerDisplay {
      font-size: 1.5em;
      margin: 20px;
      color: #444;
    }

    .info {
      margin: 10px 0;
      color: #555;
    }

    label {
      color: #333;
      margin-bottom: 5px;
    }

    button {
      font-family: Roboto-Medium, Helvetica;
      font-weight: 800px;
      padding: 10px 15px;
      margin: 5px;
      color: #B1102B;
      background-color: #ffffff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      top: 20px;
      font-size: 16px;
      text-decoration: none;
      border: 2px solid #B1102B;

    }

    button:hover {
      background-color: #b1102b;
      color: #ffffff;
      border: 2px solid #B1102B;
    }


    .modal {
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgb(0, 0, 0);
      background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
      background-color: #fefefe;
      margin: 15% auto;
      padding: 20px;
      border: 1px solid #000000;
      width: 80%;
    }

    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
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

    .button2, .button3 {
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

    hr {
      border: 2px solid #b1102b;
      height: 2px;
      background-color: #b1102b;
      margin-left: auto;
      margin-right: auto;
      width: 8%;
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
                            <p class="welcome-message">Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?></p>
                            <a href="logout.php" class="button3">Logout</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
<div class="box">
   <div class="rectangle">
       <ul>
       <li><a href="#"class="active">>Game</a></li>
           <li><a href="../php/main.php">Home</a></li>
           <li><a href="../php/help.php">How To Play</a></li>
           <li><a href="../php/leaderboard.php">Leaderboard</a></li>
           <li><a href="../php/contact.php">Contact</a></li>
       </ul>


   </div>
</div>

</nav>


</header>
  <h1> 10X10 Game</h1>
  <br>
  <!-- Displaying Player Names -->
  <h2> <?php echo htmlspecialchars($player1Name) . ' Vs. ' . htmlspecialchars($player2Name); ?> </h2> 

  <button id="restartButton" onclick="restartGame()">Restart Game</button>

  <!-- Dropdown menu to change board color -->
  <label for="boardColorSelect">Board Color:</label>
  <select id="boardColorSelect" onchange="changeBoardColor()">
    <option value="scheme1">Default</option>
    <option value="scheme2">FSU Colors</option>
  </select>


  <div id="currentPlayerDisplay">
    <?php echo $player1Name; ?>'s Turn
  </div>

  <div class="game-container">
    <div class="player-info-container">
      <!-- Updated Player Info -->
      <label for="playerOneColor">
        <?php echo htmlspecialchars($player1Name); ?> Color:
      </label>
      <input type="color" id="playerOneColor" name="playerOneColor" value="#ffffff" />
      <div id="player1PieceCount">Pieces Left 20</div>
      <div id="player1Time">Time: 00:00</div> <br> <br> <br> <br> <br> <br> <br>
      

    <!-- Spacing for layout -->
    <br><br><br><br><br><br><br>
      <label for="playerTwoColor"> <?php echo htmlspecialchars($player2Name); ?> Color: </label>
      <input type="color" id="playerTwoColor" name="playerTwoColor" value="#000000" />
      <div id="player2PieceCount"> Pieces Left 20</div>
      <div id="player2Time"> Time: 00:00</div>
    </div>

        <!-- Game Canvas -->
    <canvas id="gameCanvas" width="500" height="500"></canvas>
  </div>

  <!-- Hidden elements to store player names -->
  <input type="hidden" id="player1Name" value="<?php echo htmlspecialchars($player1Name); ?>">
  <input type="hidden" id="player2Name" value="<?php echo htmlspecialchars($player2Name); ?>">


  <script>

    // JavaScript code to initialize player names
    var player1Name = document.getElementById("player1Name").value;
    var player2Name = document.getElementById("player2Name").value;

    function restartGame() {
      location.reload();
    }


    function changeBoardColor() {
      const select = document.getElementById('boardColorSelect');
      const selectedScheme = select.value;

      if (selectedScheme === 'scheme1') {
        // Set the board colors to scheme 1
        canvasBoard.boardLightColor = "#DBC8AC";
        canvasBoard.boardDarkColor = "#88594C";
      } else if (selectedScheme === 'scheme2') {
        // Set the board colors to scheme 2
        canvasBoard.boardLightColor = "#b1102b";
        canvasBoard.boardDarkColor = "#13284c";
      }

      canvasBoard.redrawBoard(); // Redraw the board with the new color scheme
    }

    // ------------------------ Class for handling the canvasBoard (Constructor)

  class CanvasBoard {
   constructor() {
      // Obtains the canvas element from the HTML and sets up the 2D rendering context.
    this.canvas = document.getElementById("gameCanvas");    
    this.ctx = this.canvas.getContext("2d");
      // Defines the width of the board's border and calculates the size of each square.
    this.borderWidth = 8;
    this.squareSize = (this.canvas.width - 2 * this.borderWidth) / 8;
      // Retrieves the initial colors for player one and player two from the HTML color input elements.
    this.playerOneColor = document.getElementById("playerOneColor").value;
    this.playerTwoColor = document.getElementById("playerTwoColor").value;
    this.initColorChange();     // Initializes event listeners for changes in player colors.
    this.gameState = this.initializeGameState();     // Initializes the game state, setting up the board with pieces in their starting positions.
    this.selectedPiece = null;      // Initializes the selected piece as null, indicating no piece is selected at the start.
    this.setupEventListeners();     // Sets up other event listeners for the game, such as canvas clicks.
    this.currentPlayer = 1;     // Sets the starting player. In this case, player 1 is set as the starting player
    this.player1Time = 0; // Initialize Player 1's time to 0 seconds
    this.player2Time = 0; // Initialize Player 2's time to 0 seconds
    this.timerInterval = null; // Initialize the timer interval
    this.boardLightColor = "#DBC8AC"; // Default light color
    this.boardDarkColor = "#88594C"; // Default dark color
    this.redrawBoard();
    this.startTimer(); // Start the timer for Player 1
  }


      startTimer() {
        // Clear any existing timer to prevent multiple intervals
        if (this.timerInterval) {
          clearInterval(this.timerInterval);
        }

        this.timerInterval = setInterval(() => {
          if (this.currentPlayer === 1) {
            this.player1Time++; // Increment Player 1's time
          } else {
            this.player2Time++; // Increment Player 2's time
          }
          this.updateTimeDisplay(); // Update the time display
        }, 1000); // Update every 1 second (1000 milliseconds)
      }

      stopTimer() {
        if (this.timerInterval) {
          clearInterval(this.timerInterval);
          this.timerInterval = null; // Clear the interval ID
        }
      }


      
      // Update the time display on the screen
      updateTimeDisplay() {
        const player1TimeDisplay = document.getElementById("player1Time");
        const player2TimeDisplay = document.getElementById("player2Time");
        player1TimeDisplay.textContent = `Player 1 Time: ${this.formatTime(
          this.player1Time
        )}`;
        player2TimeDisplay.textContent = `Player 2 Time: ${this.formatTime(
          this.player2Time
        )}`;
      }

      // Format the time in seconds as "MM:SS" (e.g., "02:45")
      formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = seconds % 60;
        const formattedMinutes = String(minutes).padStart(2, "0");
        const formattedSeconds = String(remainingSeconds).padStart(2, "0");
        return `${formattedMinutes}:${formattedSeconds}`;
      }

      countPlayerPieces() {
        let playerOneCount = 0;
        let playerTwoCount = 0;

        for (let row = 0; row < this.gameState.length; row++) {
          for (let col = 0; col < this.gameState[row].length; col++) {
            if (this.gameState[row][col] === 1) {
              playerOneCount++;
            } else if (this.gameState[row][col] === 2) {
              playerTwoCount++;
            }
            // Add additional checks here for king pieces if you have different values for them
          }
        }

        return { playerOneCount, playerTwoCount };
      }

      updatePieceCounts() {
        const { playerOneCount, playerTwoCount } = this.countPlayerPieces();
        document.getElementById(
          "player1PieceCount"
        ).textContent = `Player 1 Pieces: ${playerOneCount}`;
        document.getElementById(
          "player2PieceCount"
        ).textContent = `Player 2 Pieces: ${playerTwoCount}`;
      }

      // Add this function inside the CanvasBoard class
      applyBoardStyle(style) {
        const canvas = document.getElementById("gameCanvas");
        const ctx = canvas.getContext("2d");

        switch (style) {
          case "default":
            // Apply default board style
            for (let row = 0; row < 10; row++) {
              for (let col = 0; col < 10; col++) {
                ctx.fillStyle = (row + col) % 2 === 0 ? "#DBC8AC" : "#88594C";
                ctx.fillRect(
                  this.borderWidth + col * this.squareSize,
                  this.borderWidth + row * this.squareSize,
                  this.squareSize,
                  this.squareSize



                );
              }
            }
            break;

          case "wood":
            // Apply wood texture board style
            // Implement your wood texture drawing logic here
            // You can use patterns or images to create a wood texture
            // Example:
            ctx.fillStyle = "url(/Users/mariatomaz/Desktop/New/wood.jpg)";
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            break;

          case "checkerboard":
            // Apply checkerboard style
            // Implement checkerboard drawing logic here
            // Example:
            for (let row = 0; row < 10; row++) {
              for (let col = 0; col < 10; col++) {
                ctx.fillStyle = (row + col) % 2 === 0 ? "#FFFFFF" : "#000000";
                ctx.fillRect(
                  this.borderWidth + col * this.squareSize,
                  this.borderWidth + row * this.squareSize,
                  this.squareSize,
                  this.squareSize
                );
              }
            }
            break;
        }
      }



      getValidMoves(row, col) {
        let validMoves = [];
        let playerPiece = this.gameState[row][col];
        let opponent = this.currentPlayer === 1 ? 2 : 1;

        // Check for regular and backward moves (for capturing)
        const potentialMoves = [
          { dr: 1, dc: -1 }, // Forward left
          { dr: 1, dc: 1 }, // Forward right
          { dr: -1, dc: -1 }, // Backward left (for capturing)
          { dr: -1, dc: 1 }, // Backward right (for capturing)
        ];

        potentialMoves.forEach(({ dr, dc }) => {
          const newRow = row + dr;
          const newCol = col + dc;
          const captureRow = row + 2 * dr;
          const captureCol = col + 2 * dc;

          // Check for regular moves
          if (dr === (this.currentPlayer === 1 ? 1 : -1)) {
            // Regular move direction based on player
            if (
              this.isValidSquare(newRow, newCol) &&
              this.gameState[newRow][newCol] === 0
            ) {
              validMoves.push({ newRow, newCol });
            }
          }

          // Check for captures
          if (
            this.isValidSquare(captureRow, captureCol) &&
            this.gameState[captureRow][captureCol] === 0 &&
            this.gameState[newRow][newCol] === opponent
          ) {
            validMoves.push({ newRow: captureRow, newCol: captureCol });
          }
        });

      
        return validMoves;
      }

      // Utility method to check if a square is within the board bounds
      isValidSquare(row, col) {
        return row >= 0 && row < 10 && col >= 0 && col < 10;
      }
    
      initializeGameState() {
        let state = [];
        for (let row = 0; row < 10; row++) { // change from 8 to 10
          let rowState = [];
          for (let col = 0; col < 10; col++) { // change from 8 to 10
            if (row < 4 && (row + col) % 2 !== 0) rowState.push(1); // adjust row < 4 for initial piece placement
            else if (row > 5 && (row + col) % 2 !== 0) rowState.push(2); // adjust row > 5
            else rowState.push(0);
          }
          state.push(rowState);
        }
        return state;
      }


      initColorChangeListeners() {
        document
          .getElementById("playerOneColor")
          .addEventListener("change", (event) => {
            this.playerOneColor = event.target.value;
            this.redrawBoard();
          });

        document
          .getElementById("playerTwoColor")
          .addEventListener("change", (event) => {
            this.playerTwoColor = event.target.value;
            this.redrawBoard();
          });
      }

      setupEventListeners() {
        this.canvas.addEventListener(
          "click",
          this.handleCanvasClick.bind(this)
        );
      }

      handleCanvasClick(event) {
        let rect = this.canvas.getBoundingClientRect();
        let x = event.clientX - rect.left;
        let y = event.clientY - rect.top;

        let col = Math.floor((x - this.borderWidth) / this.squareSize);
        let row = Math.floor((y - this.borderWidth) / this.squareSize);

        //this.handleSquareClick(row, col);
        if (row >= 0 && row < 10 && col >= 0 && col < 10) {
          this.handleSquareClick(row, col);
        }
      }

      handleSquareClick(row, col) {
        if (this.selectedPiece) {
          if (
            this.isValidMove(
              this.selectedPiece.row,
              this.selectedPiece.col,
              row,
              col
            )
          ) {
            this.movePiece(
              this.selectedPiece.row,
              this.selectedPiece.col,
              row,
              col
            );
            this.switchPlayer();
          }
          this.clearHighlightsAndArrows();
          this.selectedPiece = null;
        } else {
          if (this.gameState[row][col] === this.currentPlayer) {
            this.clearHighlightsAndArrows();
            this.selectedPiece = { row, col };
            this.highlightMoves(row, col);
          }
        }
        this.redrawBoard();
      }

      highlightMoves(row, col) {
        let validMoves = this.getValidMoves(row, col);
        validMoves.forEach(({ newRow, newCol }) => {
          this.drawArrow(row, col, newRow, newCol);
        });
      }

      drawArrow(fromRow, fromCol, toRow, toCol) {
        // Start by calculating the pixel coordinates of the start and end points
        const fromX =
          this.borderWidth + fromCol * this.squareSize + this.squareSize / 2;
        const fromY =
          this.borderWidth + fromRow * this.squareSize + this.squareSize / 2;
        const toX =
          this.borderWidth + toCol * this.squareSize + this.squareSize / 2;
        const toY =
          this.borderWidth + toRow * this.squareSize + this.squareSize / 2;

        // Arrow properties
        const headLength = 15; // Length of the arrow head
        const lineWidth = 2; // Width of the arrow line
        const color = "red"; // Color of the arrow

        // Save the current drawing state
        this.ctx.save();

        // Start the arrow path
        this.ctx.beginPath();
        this.ctx.moveTo(fromX, fromY);
        this.ctx.lineTo(toX, toY);

        // Calculate the angle of the line
        var angle = Math.atan2(toY - fromY, toX - fromX);

        // Draw the starting arrowhead
        this.ctx.moveTo(fromX, fromY);
        this.ctx.lineTo(
          fromX - headLength * Math.cos(angle - Math.PI / 6),
          fromY - headLength * Math.sin(angle - Math.PI / 6)
        );
        this.ctx.moveTo(fromX, fromY);
        this.ctx.lineTo(
          fromX - headLength * Math.cos(angle + Math.PI / 6),
          fromY - headLength * Math.sin(angle + Math.PI / 6)
        );

        // Draw the ending arrowhead
        this.ctx.moveTo(toX, toY);
        this.ctx.lineTo(
          toX - headLength * Math.cos(angle - Math.PI / 6),
          toY - headLength * Math.sin(angle - Math.PI / 6)
        );
        this.ctx.moveTo(toX, toY);
        this.ctx.lineTo(
          toX - headLength * Math.cos(angle + Math.PI / 6),
          toY - headLength * Math.sin(angle + Math.PI / 6)
        );

        // Set arrow line properties
        this.ctx.strokeStyle = color;
        this.ctx.lineWidth = lineWidth;
        this.ctx.stroke();

        // Restore the previous drawing state
        this.ctx.restore();
      }

      isValidMove(fromRow, fromCol, toRow, toCol) {
        if (toRow < 0 || toRow >= 10 || toCol < 0 || toCol >= 10)
          return false;
        if (this.gameState[toRow][toCol] !== 0) return false;

        let rowDiff = toRow - fromRow;
        let colDiff = toCol - fromCol;

        // Check for regular moves (forward only for non-king pieces)
        if (Math.abs(rowDiff) === 1 && Math.abs(colDiff) === 1) {
          if (this.currentPlayer === 1 && rowDiff !== 1) return false; // Player 1 can only move down for regular moves
          if (this.currentPlayer === 2 && rowDiff !== -1) return false; // Player 2 can only move up for regular moves
          return true; // Regular move
        }

        // Check for capture moves (can be forward or backward)
        if (Math.abs(rowDiff) === 2 && Math.abs(colDiff) === 2) {
          let midRow = (fromRow + toRow) / 2;
          let midCol = (fromCol + toCol) / 2;
          let opponent = this.currentPlayer === 1 ? 2 : 1;
          return this.gameState[midRow][midCol] === opponent; // Capture move
        }

        return false;
      }

      movePiece(fromRow, fromCol, toRow, toCol) {
        this.gameState[toRow][toCol] = this.gameState[fromRow][fromCol];
        this.gameState[fromRow][fromCol] = 0;

        if (Math.abs(fromRow - toRow) === 2) {
          let midRow = (fromRow + toRow) / 2;
          let midCol = (fromCol + toCol) / 2;
          this.gameState[midRow][midCol] = 0;
        }

        // Update and display the piece counts
        this.updatePieceCounts();

        // Check for a winner (you may want to move this to a separate method)
        const { playerOneCount, playerTwoCount } = this.countPlayerPieces();
        this.declareWinner(playerOneCount, playerTwoCount); // Call declareWinner here
      }
      /*
      switchPlayer() {
        this.currentPlayer = this.currentPlayer === 1 ? 2 : 1;
        // Update the display for the current player
        const currentPlayerText = `Player ${this.currentPlayer}'s Turn`;
        document.getElementById("currentPlayerDisplay").textContent =
          currentPlayerText;
      }
      */
      /*
       switchPlayer() {
           this.currentPlayer = this.currentPlayer === 1 ? 2 : 1;
           // Update the display for the current player
           const currentPlayerName = this.currentPlayer === 1 ? '<?php echo $player1Name; ?>' : '<?php echo $player2Name; ?>';
           const currentPlayerText = `${currentPlayerName}'s Turn`;
           document.getElementById("currentPlayerDisplay").textContent = currentPlayerText;
           this.startTimer();
       }
       */
      // Switch players and update timer
      switchPlayer() {
        // Stop the timer for the current player before switching
        this.stopTimer();

        this.currentPlayer = this.currentPlayer === 1 ? 2 : 1;

        // Update the display for the current player
        const currentPlayerName = this.currentPlayer === 1 ? '<?php echo $player1Name; ?>' : '<?php echo $player2Name; ?>';
        const currentPlayerText = `${currentPlayerName}'s Turn`;
        document.getElementById("currentPlayerDisplay").textContent = currentPlayerText;

        // Start the timer for the new current player
        this.startTimer();
      }

      drawBoard() {
        for (let row = 0; row < 10; row++) {
          for (let col = 0; col < 10; col++) {
            this.ctx.fillStyle =
              (row + col) % 2 === 0 ? this.boardLightColor : this.boardDarkColor;
            this.ctx.fillRect(
              this.borderWidth + col * this.squareSize,
              this.borderWidth + row * this.squareSize,
              this.squareSize,
              this.squareSize
            );
          }
        }
      }
      // Function to change the board color based on the dropdown selection
      changeBoardColor() {
        const select = document.getElementById('boardColorSelect');
        const selectedScheme = select.value;

        if (selectedScheme === 'scheme1') {
          // Set the board colors to scheme 1
          this.boardLightColor = "#DBC8AC";
          this.boardDarkColor = "#88594C";
        } else if (selectedScheme === 'scheme2') {
          // Set the board colors to scheme 2
          this.boardLightColor = "#b1102b";
          this.boardDarkColor = "#13284c";
        }

        redrawBoard(); // Redraw the board with the new color scheme
      }

      drawInitialPieces() {
        for (let row = 0; row < 10; row++) {
          for (let col = 0; col < 10; col++) {
            if (this.gameState[row][col] === 1) {
              this.drawPiece(row, col, this.playerOneColor);
            } else if (this.gameState[row][col] === 2) {
              this.drawPiece(row, col, this.playerTwoColor);
            }
          }
        }
      }

      drawPiece(row, col, color) {
        this.ctx.beginPath();
        this.ctx.arc(
          this.borderWidth + col * this.squareSize + this.squareSize / 2,
          this.borderWidth + row * this.squareSize + this.squareSize / 2,
          this.squareSize / 2 - 5,
          0,
          2 * Math.PI
        );
        this.ctx.fillStyle = color;
        this.ctx.fill();
        this.ctx.closePath();
      }

      drawFrame() {
        this.ctx.strokeStyle = "#734F45";
        this.ctx.lineWidth = this.borderWidth;
        this.ctx.strokeRect(
          this.borderWidth / 2,
          this.borderWidth / 2,
          this.canvas.width - this.borderWidth,
          this.canvas.height - this.borderWidth
        );
      }

      redrawBoard() {
        //this.clearCanvas();
        this.clearHighlightsAndArrows();
        this.drawBoard();
        this.drawInitialPieces();
        this.drawFrame();
        if (this.selectedPiece) {
          this.highlightMoves(this.selectedPiece.row, this.selectedPiece.col);
        }
      }
      /*
      clearCanvas(){
        this.ctx.clearRect(0, 0, this.canvas.width,this.canvas.height);
      }
      */
      // This clearHighlightsAndArrows method should be inside the CanvasBoard class
      clearHighlightsAndArrows() {
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
      }

      declareWinner(playerOneCount, playerTwoCount) {
        var winnerName = '';
        var loserName = '';
        var winTime = '';
        var playerOnePiecesConquered = INITIAL_PIECE_COUNT - playerTwoCount;
        var playerTwoPiecesConquered = INITIAL_PIECE_COUNT - playerOneCount;

        if (playerOneCount === 0) {
          winnerName = player2Name;
          loserName = player1Name;
          winTime = this.formatTime(this.player2Time);
          alert(`${winnerName} Wins! Time: ${winTime}. Pieces conquered: ${playerTwoPiecesConquered} and ${loserName} Lost!!!`);
        } else if (playerTwoCount === 0) {
          winnerName = player1Name;
          loserName = player2Name;
          winTime = this.formatTime(this.player1Time);
          alert(`${winnerName} Wins! Time: ${winTime}. Pieces conquered: ${playerOnePiecesConquered} and ${loserName} Lost!!!`);
        }

        // Assuming the player who has 0 pieces is the loser and therefore the other player is the winner.
        var piecesConquered = (playerOneCount === 0) ? playerTwoPiecesConquered : playerOnePiecesConquered;

        if (winnerName) {
          fetch(`update_game_result.php?winnerName=${encodeURIComponent(winnerName)}&loserName=${encodeURIComponent(loserName)}&winTime=${encodeURIComponent(winTime)}&piecesConquered=${encodeURIComponent(piecesConquered)}`)
            .then(response => response.text())
            .then(data => console.log(data));
        }
      }



      displayUserGames(userName) {
        fetch(`../php/get_user_games.php?userName=${encodeURIComponent(userName)}`)
          .then(response => response.json())
          .then(games => {
            const historyContainer = document.getElementById('userGameHistory');
            historyContainer.innerHTML = ''; // Clear previous content

            if (games.length === 0) {
              historyContainer.innerHTML = '<p>No games played yet.</p>';
            } else {
              games.forEach(game => {
                const gameDiv = document.createElement('div');
                gameDiv.classList.add('game-entry'); // Add a class for styling

                // Format the game data as needed
                gameDiv.innerHTML = `
                    <p>Game ID: ${game.game_id}</p>
                    <p>Winner: ${game.winner}</p>
                    <p>Loser: ${game.loser}</p>
                    <p>Winning Time: ${game.win_time}</p>
                `;

                historyContainer.appendChild(gameDiv);
              });
            }
          });
      }
      fetchLeaderboard() {
        fetch('../php/get_leaderboard.php')
          .then(response => response.json())
          .then(data => {
            displayLeaderboard(data);
          })
          .catch(error => console.error('Error:', error));
      }

      displayLeaderboard(leaderboardData) {
        const leaderboardContainer = document.getElementById('leaderboardContainer');
        leaderboardContainer.innerHTML = ''; // Clear previous content

        leaderboardData.forEach(player => {
          let playerDiv = document.createElement('div');
          playerDiv.innerHTML = `Name: ${player.Name}, Wins: ${player.wins}, Games Played: ${player.games_played}, Total Time Played: ${player.total_time_played}`;
          leaderboardContainer.appendChild(playerDiv);
        });
      }




      fetchWinner(playerOneCount, playerTwoCount) {
        var winnerName = '';
        var winTime = '';

        if (playerOneCount === 0) {
          winnerName = player2Name;
          winTime = this.formatTime(this.player2Time); // Format the time to string
        } else if (playerTwoCount === 0) {
          winnerName = player1Name;
          winTime = this.formatTime(this.player1Time); // Format the time to string
        }

        if (winnerName) {
          alert(`${winnerName} Wins! Time: ${winTime}`);
          const params = new URLSearchParams({
            winnerName: encodeURIComponent(winnerName),
            winTime: encodeURIComponent(winTime)
          });

          fetch(`update_winner.php?${params.toString()}`)
            .then(response => response.text())
            .then(data => console.log(data))
            .catch(error => console.error('Error:', error));
        }
      }
    }

    const canvasBoard = new CanvasBoard();


  </script>
</body>

</html>
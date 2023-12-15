<?php
session_start();

// Database connection details
include 'db_connection.php';

$player1Name = isset($_GET['player1Name']) ? $_GET['player1Name'] : 'Player 1';
$player2Name = isset($_GET['player2Name']) ? $_GET['player2Name'] : 'Player 2';

?>

<!DOCTYPE html>
<html>
<head>

    <title>8x8 Checkers Game</title>
    <link rel="stylesheet" href="../css/styles.css">

<!-- START STYLE FOR GAME EIGHT -->
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
}


#player1PieceCount,
#player2PieceCount,
#player1Time,
#player2Time {
    margin-bottom: 5px;
}

    /* Game Container */


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
<h1>8X8 Game</h1>

<!-- Displaying Player Names -->
<h2><?php echo htmlspecialchars($player1Name) . ' Vs. ' . htmlspecialchars($player2Name); ?></h2>

<!-- Game Control Buttons and Options -->
<div class="game-controls">
    <!-- Restart Button -->
    <button id="restartButton" onclick="restartGame()">Restart Game</button>

    <!-- Board Color Selection Dropdown -->
    <label for="boardColorSelect">Board Color:</label>
    <select id="boardColorSelect" onchange="changeBoardColor()">
        <option value="scheme1">Default</option>
        <option value="scheme2">FSU Colors</option>
    </select>

    <!-- Displaying Current Player's Turn -->
    <div id="currentPlayerDisplay"><?php echo $player1Name; ?>'s Turn</div>
</div>

<!-- Game Container -->
<div class="game-container">
    <!-- Player Information Section -->
    <div class="player-info-container">
        <!-- Player One Info -->
        <label for="playerOneColor"><?php echo htmlspecialchars($player1Name); ?> Color:</label>
        <input type="color" id="playerOneColor" name="playerOneColor" value="#ffffff" />
        <div id="player1PieceCount">Pieces Left 12</div>
        <div id="player1Time">Time: 00:00</div>

        <!-- Spacing for layout -->
        <br><br><br><br><br><br><br>

        <!-- Player Two Info -->
        <label for="playerTwoColor"><?php echo htmlspecialchars($player2Name); ?> Color:</label>
        <input type="color" id="playerTwoColor" name="playerTwoColor" value="#000000" />
        <div id="player2PieceCount">Pieces Left 12</div>
        <div id="player2Time">Time: 00:00</div>
    </div>

    <!-- Game Canvas -->
    <canvas id="gameCanvas" width="400" height="400"></canvas>
</div>

<!-- Hidden Elements to Store Player Names -->
<input type="hidden" id="player1Name" value="<?php echo htmlspecialchars($player1Name); ?>">
<input type="hidden" id="player2Name" value="<?php echo htmlspecialchars($player2Name); ?>">


<script>

const INITIAL_PIECE_COUNT = 12; // Global constant for initial piece count

// Retrieving player names from hidden inputs
var player1Name = document.getElementById("player1Name").value;
var player2Name = document.getElementById("player2Name").value;

// Function to restart the game - Default 
function restartGame() {
  location.reload();
}

// Function to change the board color - Default
function changeBoardColor() {
  const select = document.getElementById("boardColorSelect");
  const selectedScheme = select.value;
    // Change color scheme based on selection
  if (selectedScheme === "scheme1") {
    // Set the board colors to scheme 1
    canvasBoard.boardLightColor = "#DBC8AC";
    canvasBoard.boardDarkColor = "#88594C";
  } else if (selectedScheme === "scheme2") {
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


  //----------------------------------------------------------//  Utility Methods //---------------------------------------------------------- //

// ------------------------  Method to check if a piece is a king
// Pieces are represented by numbers, with 3 and 4 typically representing king pieces.
// The method returns true if the piece is a king (either 3 or 4) and false otherwise.
isKingPiece(piece) {
    return piece === 3 || piece === 4;
  }

  // ------------------------ method to Checks if a given board square is within the playable area
// The game board is assumed to be 8x8, so valid rows and columns range from 0 to 7 (inclusive).
// Returns true if both row and column are within this range, false otherwise.

  isValidSquare(row, col) {
    return row >= 0 && row < 8 && col >= 0 && col < 8;
  }
  

// ------------------------ Helper method to check if the piece at the new location is an opponent piece
// This method is useful in determining valid moves, especially for capturing moves.
// currentPlayerPiece is the piece making the move, and opponentPiece is the piece at the move's destination.
// Returns true if the piece at the destination is an opponent's piece.
// Includes logic for regular pieces (1 vs 2) and kings (3 vs 4).

isOpponentPiece(fromRow, fromCol, toRow, toCol) {
    let currentPlayerPiece = this.gameState[fromRow][fromCol];
    let opponentPiece = this.gameState[toRow][toCol];

    return (
        (currentPlayerPiece === 1 && opponentPiece === 2) ||
        (currentPlayerPiece === 2 && opponentPiece === 1) ||
        (currentPlayerPiece === 3 && opponentPiece !== 3 && opponentPiece !== 0) || // King of player 1
        (currentPlayerPiece === 4 && opponentPiece !== 4 && opponentPiece !== 0)   // King of player 2
    );
}
// ------------------------ Method to format the time display

formatTime(seconds) {
    const minutes = Math.floor(seconds / 60);
    const remainingSeconds = seconds % 60;
    const formattedMinutes = String(minutes).padStart(2, "0");
    const formattedSeconds = String(remainingSeconds).padStart(2, "0");
    return `${formattedMinutes}:${formattedSeconds}`;
  }

    //----------------------------------------------------------// Game Flow Control  //---------------------------------------------------------- //

  //----------------------------------------------------------//  Game State Initialization  //---------------------------------------------------------- //

// ------------------------ Initializes the game state with pieces in starting positions
// The game state is represented by a two-dimensional array where each cell corresponds to a board square.
// `1` represents a piece for player one, `2` for player two, and `0` for an empty square.
// Player one's pieces are positioned in the first three rows, and player two's pieces in the last three rows.
// Pieces are placed on squares where the sum of the row and column indexes is odd (checkered pattern).

initializeGameState() {
    let state = [];
    for (let row = 0; row < 8; row++) {
      let rowState = [];
      for (let col = 0; col < 8; col++) {
        if (row < 3 && (row + col) % 2 !== 0) rowState.push(1);
        else if (row > 4 && (row + col) % 2 !== 0) rowState.push(2);
        else rowState.push(0);
      }
      state.push(rowState);
    }
    return state;
  }


// ------------------------ Counts the number of pieces each player has on the board
// This method is useful for determining the game state, such as checking for a win condition.
// Loops through each cell in the gameState and increments the count for the respective player.

countPlayerPieces() {
    let playerOneCount = 0;
    let playerTwoCount = 0;

    
    // Loop through the game state to count pieces

    for (let row = 0; row < this.gameState.length; row++) {
      for (let col = 0; col < this.gameState[row].length; col++) {
        if (this.gameState[row][col] === 1) {
          playerOneCount++; // Count player one's pieces

        } else if (this.gameState[row][col] === 2) {
          playerTwoCount++; // Count player two's pieces
        }
      }
    }

    return { playerOneCount, playerTwoCount };
  }

// ------------------------ Updates the display of the piece counts for both players
// Retrieves the current counts using the countPlayerPieces method.
// Then updates the text content of the respective HTML elements to reflect the current counts.

updatePieceCounts() {
    const { playerOneCount, playerTwoCount } = this.countPlayerPieces();
    document.getElementById(
      "player1PieceCount"
    ).textContent = `Player 1 Pieces: ${playerOneCount}`;
    document.getElementById(
      "player2PieceCount"
    ).textContent = `Player 2 Pieces: ${playerTwoCount}`;
  }




 //----------------------------------------------------------//  START TIME FUNCTIONS  //---------------------------------------------------------- //
// ------------------------ Method to start the game timer
startTimer() {
    if (this.timerInterval) {
      clearInterval(this.timerInterval);
    }

    this.timerInterval = setInterval(() => {
      if (this.currentPlayer === 1) {
        this.player1Time++;
      } else {
        this.player2Time++;
      }
      this.updateTimeDisplay();
    }, 1000);
  }


// ------------------------ Method to stop the game timer
  stopTimer() {
    if (this.timerInterval) {
      clearInterval(this.timerInterval);
      this.timerInterval = null;
    }
  }

// ------------------------ Method to update the time display
    updateTimeDisplay() {
    const player1TimeDisplay = document.getElementById("player1Time");
    const player2TimeDisplay = document.getElementById("player2Time");
    player1TimeDisplay.textContent = `Time: ${this.formatTime(
      this.player1Time
    )}`;
    player2TimeDisplay.textContent = `Time: ${this.formatTime(
      this.player2Time
    )}`;
  }


  //----------------------------------------------------------// END TIME FUNCTIONS  //---------------------------------------------------------- //

 // ------------------------Switches the turn from one player to the other
// First, it stops the timer for the current player.
// Then, it toggles the currentPlayer between 1 and 2.
// Updates the display to show whose turn it is now.
// Finally, starts the timer for the new current player
 switchPlayer() {
    this.stopTimer();
    this.currentPlayer = this.currentPlayer === 1 ? 2 : 1;

    // Update the display for the current player
    const currentPlayerName =
      this.currentPlayer === 1
        ? "<?php echo $player1Name; ?>"
        : "<?php echo $player2Name; ?>";
    const currentPlayerText = `${currentPlayerName}'s Turn`;
    document.getElementById("currentPlayerDisplay").textContent =
      currentPlayerText;

    // Start the timer for the new current player
    this.startTimer();
  }

// ------------------------  Handles clicks on the canvas, translating them to game actions
// Calculates the row and column of the board where the click occurred.
// Then, calls handleSquareClick to handle actions specific to the clicked square.

handleCanvasClick(event) {
    let rect = this.canvas.getBoundingClientRect();
    let x = event.clientX - rect.left;
    let y = event.clientY - rect.top;

    let col = Math.floor((x - this.borderWidth) / this.squareSize);
    let row = Math.floor((y - this.borderWidth) / this.squareSize);

    this.handleSquareClick(row, col);
  }

// ------------------------ Handles what happens when a specific square on the board is clicked
// Checks if there's a selected piece. If yes, attempts to move it to the clicked square.
// Validates the move, performs it if valid, and switches the player's turn.
// If no piece is selected, checks if the clicked square has a valid piece to select.

  handleSquareClick(row, col) {
    console.log(`Square clicked: Row ${row}, Col ${col}`);
    if (this.selectedPiece) {
      console.log(
        `Attempting to move selected piece from Row ${this.selectedPiece.row}, Col ${this.selectedPiece.col} to Row ${row}, Col ${col}`
      );
      if (
        this.isValidMove(
          this.selectedPiece.row,
          this.selectedPiece.col,
          row,
          col
        )
      ) {
        console.log("Move is valid, proceeding to move piece.");
        this.movePiece(
          this.selectedPiece.row,
          this.selectedPiece.col,
          row,
          col
        );
        this.switchPlayer();
      } else {
        console.log("Move is invalid.");
      }
      this.clearHighlightsAndArrows();
      this.selectedPiece = null;
    } else {
      if (this.isKingPiece(this.gameState[row][col])) {
        console.log("King piece selected.");
        this.selectedPiece = { row, col };
      } else if (this.gameState[row][col] === this.currentPlayer) {
        console.log("Regular piece selected.");
        this.selectedPiece = { row, col };
      }
      if (this.selectedPiece) {
        let validMoves = this.getValidMoves(row, col);
        console.log("Valid moves for selected piece:", validMoves);
        this.highlightMoves(row, col);
      }
    }
    this.redrawBoard();
  }

// ------------------------ Calculates valid moves for a selected piece
// Determines move directions based on whether the piece is a king or a regular piece.
// Checks each potential move direction for validity (empty square for regular moves, opponent piece for captures).
// Returns a list of valid move positions.


getValidMoves(row, col) {
    let validMoves = [];
    let playerPiece = this.gameState[row][col];
    let isKing = playerPiece === 3 || playerPiece === 4;
    let isMultiCapture = false;

    // Directions a king can move: up-left, up-right, down-left, down-right
    const kingDirections = [
      { dr: -1, dc: -1 },
      { dr: -1, dc: 1 },
      { dr: 1, dc: -1 },
      { dr: 1, dc: 1 },
    ];

    // Directions for regular pieces
    const directions = isKing
      ? kingDirections
      : playerPiece === 1
      ? [
          { dr: 1, dc: -1 },
          { dr: 1, dc: 1 },
        ] // Player 1 piece
      : [
          { dr: -1, dc: -1 },
          { dr: -1, dc: 1 },
        ]; // Player

    // Check each direction for valid moves
    directions.forEach(({ dr, dc }) => {
      let newRow = row + dr;
      let newCol = col + dc;
      // Regular move check
      if (
        this.isValidSquare(newRow, newCol) &&
        this.gameState[newRow][newCol] === 0
      ) {
        validMoves.push({ newRow, newCol });
      }
      // Capture move check
      let captureRow = row + 2 * dr;
      let captureCol = col + 2 * dc;
      if (
        this.isValidSquare(captureRow, captureCol) &&
        this.gameState[captureRow][captureCol] === 0 &&
        this.isOpponentPiece(row, col, newRow, newCol)
      ) {
        validMoves.push({ newRow: captureRow, newCol: captureCol });
      }
    });

    // If a capture has been made, filter out the simple moves
    if (isMultiCapture) {
      validMoves = validMoves.filter((move) => move.isCapture);
    }

    return validMoves;
  }


// ------------------------ Checks if a move from one square to another is valid
// Ensures the destination square is within the board boundaries and is empty.
// Determines the type of move based on whether the piece is a king or a regular piece.
// For kings, allows diagonal movement in any direction.
// For regular pieces, allows diagonal movement forward only, and checks for valid captures.

isValidMove(fromRow, fromCol, toRow, toCol) {
    if (toRow < 0 || toRow >= 8 || toCol < 0 || toCol >= 8) return false;
    if (this.gameState[toRow][toCol] !== 0) return false;

    let piece = this.gameState[fromRow][fromCol];
    let isKing = piece === 3 || piece === 4;
    let rowDiff = toRow - fromRow;
    let colDiff = toCol - fromCol;

    // King move
    if (isKing) {
      // Allow king to move diagonally in any direction
      if (Math.abs(rowDiff) === 1 && Math.abs(colDiff) === 1) {
        return true; // Regular move for king
      }
      if (Math.abs(rowDiff) === 2 && Math.abs(colDiff) === 2) {
        let midRow = (fromRow + toRow) / 2;
        let midCol = (fromCol + toCol) / 2;
        return this.isOpponentPiece(fromRow, fromCol, midRow, midCol);
      }
    }

    // Regular piece move
    if (!isKing) {
      // Regular move
      if (Math.abs(rowDiff) === 1 && Math.abs(colDiff) === 1) {
        if ((piece === 1 && rowDiff !== 1) || (piece === 2 && rowDiff !== -1)) {
          return false;
        }
        return true;
      }

      // Capture move
      if (Math.abs(rowDiff) === 2 && Math.abs(colDiff) === 2) {
        let midRow = (fromRow + toRow) / 2;
        let midCol = (fromCol + toCol) / 2;
        return this.isOpponentPiece(fromRow, fromCol, midRow, midCol);
      }
      if (Math.abs(rowDiff) === 4 && Math.abs(colDiff) === 4) {    //checks if the piece is trying to move four squares diagonally
    // Check if both intermediate squares contain opponent pieces
    let midRow1 = fromRow + Math.sign(toRow - fromRow); //calculate the row and column of the first square that is jumped over.
    let midCol1 = fromCol + Math.sign(toCol - fromCol);
    let midRow2 = midRow1 + Math.sign(toRow - fromRow);
    let midCol2 = midCol1 + Math.sign(toCol - fromCol);

    return this.isOpponentPiece(fromRow, fromCol, midRow1, midCol1) &&
           this.isOpponentPiece(midRow1, midCol1, midRow2, midCol2) &&
           this.gameState[toRow][toCol] === 0;
}
    }

    return false;
  }

 // ------------------------ Checks if a move is a capturing move
 // A capturing move is defined as a move where the piece travels two squares diagonally,
// indicating it has jumped over an opponent's piece.

isCaptureMove(fromRow, fromCol, toRow, toCol) {
    const rowDiff = Math.abs(toRow - fromRow);
    const colDiff = Math.abs(toCol - fromCol);
    return rowDiff === 4 && colDiff === 4;  //changed from 22 to 44  - To capture two pieces, a piece would need to move over three squares (piece-empty-piece) and land on the fourth square.
}



// ------------------------ Initializes the game state with pieces in starting positions
// Sets up a standard 8x8 checkered board with players' pieces in the first and last three rows.
// Player 1's pieces are represented by 1, and Player 2's pieces by 2. Empty squares are 0.
  initializeGameState() {
    let state = [];
    for (let row = 0; row < 8; row++) {
      let rowState = [];
      for (let col = 0; col < 8; col++) {
        if (row < 3 && (row + col) % 2 !== 0) rowState.push(1);
        else if (row > 4 && (row + col) % 2 !== 0) rowState.push(2);
        else rowState.push(0);
      }
      state.push(rowState);
    }
    return state;
  }




  
 // ------------------------ Moves a piece from one square to another
// Updates the game state to reflect the new positions of the moved piece.
// Handles regular moves and captures, and checks if a piece should be crowned a king.
// Updates piece counts and checks for a winner after the move.
// Redraws the board to display the new state.
 movePiece(fromRow, fromCol, toRow, toCol) {
    let piece = this.gameState[fromRow][fromCol];
    let isKing = piece === 3 || piece === 4;
    let becomingKing = false;

    // Regular move
    this.gameState[toRow][toCol] = piece;
    this.gameState[fromRow][fromCol] = 0;

    // Check for captures
    if (Math.abs(fromRow - toRow) === 2) {
      let midRow = (fromRow + toRow) / 2;
      let midCol = (fromCol + toCol) / 2;
      this.gameState[midRow][midCol] = 0; // Remove the captured piece
    }

    // Check if a regular piece reaches the opposite end to become a king
    if (!isKing) {
      if (piece === 1 && toRow === 7) {
        this.gameState[toRow][toCol] = 3; // Player 1's piece becomes a king
        becomingKing = true;
      } else if (piece === 2 && toRow === 0) {
        this.gameState[toRow][toCol] = 4; // Player 2's piece becomes a king
        becomingKing = true;
      }
    }

    // Update piece counts and check for a winner
    this.updatePieceCounts();
    const { playerOneCount, playerTwoCount } = this.countPlayerPieces();
    this.declareWinner(playerOneCount, playerTwoCount);

    // Redraw the board to reflect the new game state
    this.redrawBoard();

    // If a piece has become a king, update its appearance
    if (becomingKing) {
      this.drawPiece(toRow, toCol, this.playerOneColor, piece === 1 ? 3 : 4);
    }
  }


 // ------------------------  Clears highlights and arrows from the board
 // Useful for resetting the board's visual state after a move or when changing turns.


 clearHighlightsAndArrows() {
    this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
  }


  //----------------------------------------------------------//  Rendering Methods  //---------------------------------------------------------- //

// ------------------------ Draws the initial state of the game board
// Iterates over each row and column, setting the fill color based on the checkered pattern.
// Fills each square with the appropriate color (light or dark).
   drawBoard() {
    for (let row = 0; row < 8; row++) {
      for (let col = 0; col < 8; col++) {
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

 // ------------------------Draws the initial positions of the pieces on the board
// Iterates through the game state array and calls drawPiece for each piece.
 drawInitialPieces() {
    for (let row = 0; row < 8; row++) {
      for (let col = 0; col < 8; col++) {
        if (this.gameState[row][col] === 1) {
          this.drawPiece(row, col, this.playerOneColor);
        } else if (this.gameState[row][col] === 2) {
          this.drawPiece(row, col, this.playerTwoColor);
        }
      }
    }
  }


 // ------------------------ Draws a single piece on the board
 // Uses the canvas arc method to draw a circle representing a piece.
// If the piece is a king, adds a distinct marking (e.g., a letter 'K' or a different color).

 drawPiece(row, col, color, pieceType) {
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

    // If the piece is a king, draw a gold crown or change its appearance
    if (pieceType === 3 || pieceType === 4) {
      // Assuming 3 and 4 represent king pieces
      this.ctx.fillStyle = "#FFD700"; // Gold color for kings
      this.ctx.font = "20px Arial";
      this.ctx.fillText(
        "K",
        this.borderWidth + col * this.squareSize + this.squareSize / 4,
        this.borderWidth + row * this.squareSize + this.squareSize / 2
      );
    }

    this.ctx.closePath();
  }

 // ------------------------ Draws the frame around the game board
// Defines the border color and width, and draws a rectangle around the edge of the canvas.



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

 // ------------------------  Highlights valid moves for the selected piece
// Obtains a list of valid moves and draws arrows from the selected piece to each valid destination.

 highlightMoves(row, col) {
    let validMoves = this.getValidMoves(row, col);
    validMoves.forEach(({ newRow, newCol }) => {
      this.drawArrow(row, col, newRow, newCol);
    });
  }

 // ------------------------  Draws an arrow on the canvas to indicate a move
 // Calculates the start and end points of the arrow based on the from and to positions.
// Draws a line with arrowheads to visually represent the move direction.

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
    const lineWidth = 3; // Width of the arrow line
    const color = "green"; // Color of the arrow

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

 
// ------------------------  Redraws the entire board, including pieces and frame
// Clears the canvas and then redraws the board, pieces, and frame.
// Used after any change in the game state that requires visual update.
redrawBoard() {
    // Clear the entire canvas to start fresh
    this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

    // Draw the board squares
    for (let row = 0; row < 8; row++) {
      for (let col = 0; col < 8; col++) {
        // Set the fill style depending on whether the square is light or dark
        this.ctx.fillStyle =
          (row + col) % 2 === 0 ? this.boardLightColor : this.boardDarkColor;
        // Draw the square
        this.ctx.fillRect(
          this.borderWidth + col * this.squareSize,
          this.borderWidth + row * this.squareSize,
          this.squareSize,
          this.squareSize
        );
      }
    }

    // Draw the pieces on the board based on the gameState
    for (let row = 0; row < 8; row++) {
      for (let col = 0; col < 8; col++) {
        let pieceType = this.gameState[row][col];
        if (pieceType === 1) {
          // Draw player 1 regular piece
          this.drawPiece(row, col, this.playerOneColor, pieceType);
        } else if (pieceType === 2) {
          // Draw player 2 regular piece
          this.drawPiece(row, col, this.playerTwoColor, pieceType);
        } else if (pieceType === 3) {
          // Draw player 1 king piece
          this.drawPiece(row, col, this.playerOneColor, pieceType);
        } else if (pieceType === 4) {
          // Draw player 2 king piece
          this.drawPiece(row, col, this.playerTwoColor, pieceType);
        }
      }
    }

    // Redraw the border/frame of the board
    this.ctx.strokeStyle = "#734F45";
    this.ctx.lineWidth = this.borderWidth;
    this.ctx.strokeRect(
      this.borderWidth / 2,
      this.borderWidth / 2,
      this.canvas.width - this.borderWidth,
      this.canvas.height - this.borderWidth
    );

    // If there is a selected piece, highlight its valid moves
    if (this.selectedPiece) {
      this.highlightMoves(this.selectedPiece.row, this.selectedPiece.col);
    }
  }

  
    //----------------------------------------------------------//  Event Listener //---------------------------------------------------------- //

  // ------------------------  change of players' pieces
// When a player chooses a new color, updates the piece color and redraws the board.

  initColorChange() {
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

  // ------------------------ Sets up the event listener for canvas clicks
// Listens for clicks on the canvas and handles them based on the game logic.

  setupEventListeners() {
    this.canvas.addEventListener("click", this.handleCanvasClick.bind(this));
  }


 // ------------------------ Function to change the board color based on the dropdown selection
 // Changes the light and dark square colors of the board and redraws it.

  changeBoardColor() {
    const select = document.getElementById("boardColorSelect");
    const selectedScheme = select.value;

    if (selectedScheme === "scheme1") {
      this.boardLightColor = "#DBC8AC";
      this.boardDarkColor = "#88594C";
    } else if (selectedScheme === "scheme2") {
      this.boardLightColor = "#b1102b";
      this.boardDarkColor = "#13284c";
    }

    this.redrawBoard(); // Redraw the board with the new color scheme
  }


   // ------------------------ Declares the winner of the game and updates the game result
//Declares the winner of the game and updates the game result.
//The winner is determined by the player who has not lost all their pieces.
// Displays an alert with the winner's name, time taken, and pieces conquered.
// If there is a winner, sends the game result to the server for record-keeping.

  declareWinner(playerOneCount, playerTwoCount) {
    var winnerName = "";
    var loserName = "";
    var winTime = "";
    var playerOnePiecesConquered = INITIAL_PIECE_COUNT - playerTwoCount;
    var playerTwoPiecesConquered = INITIAL_PIECE_COUNT - playerOneCount;

    if (playerOneCount === 0) {     // Determine the winner and loser based on the remaining piece count.
            // If player one has no pieces left, player two wins.
      winnerName = player2Name;
      loserName = player1Name;
      winTime = this.formatTime(this.player2Time);
      alert(
        `${winnerName} Wins! Time: ${winTime}. Pieces conquered: ${playerTwoPiecesConquered} and ${loserName} Lost!!! -- Pieces conquered: ${playerOnePiecesConquered}`
      );
    } else if (playerTwoCount === 0) {       // If player two has no pieces left, player one wins.
      winnerName = player1Name;
      loserName = player2Name;
      winTime = this.formatTime(this.player1Time);
      alert(
        `${winnerName} Wins! Time: ${winTime}. Pieces conquered: ${playerOnePiecesConquered} and ${loserName} Lost!!! -- Pieces conquered: ${playerTwoPiecesConquered} `
      );
    }

    // Assuming the player who has 0 pieces is the loser and therefore the other player is the winner.
    var piecesConquered =
      playerOneCount === 0
        ? playerTwoPiecesConquered
        : playerOnePiecesConquered;
    // Display the result in an alert.
    if (winnerName) {
      fetch(
        `update_game_result.php?winnerName=${encodeURIComponent(
          winnerName
        )}&loserName=${encodeURIComponent(
          loserName
        )}&winTime=${encodeURIComponent(
          winTime
        )}&piecesConquered=${encodeURIComponent(piecesConquered)}`
      )
        .then((response) => response.text())
        .then((data) => console.log(data));
    }
  }
}

// Class initiation

const canvasBoard = new CanvasBoard();
</script>
</body>
</html>
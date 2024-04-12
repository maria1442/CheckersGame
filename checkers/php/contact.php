<?php
session_start();
// Database connection details
include 'db_connection.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/styles.css">
  <link rel="icon" href="/images/bb.png" type="image/png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

  <title>Contact</title>

  <link rel="icon" href="bb.png" type="image/png">

  <style>
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

<body data-theme="light">
<header>

  <!--Nav Bar-->
  <nav>

    <div class="navbar">
      <div class="logo-container">
        <img class="element" src="bb.png" alt="BBLogo">
      </div>
      <div class="auth-buttons">
        <?php if (!isset($_SESSION['name'])): ?> <!-- Start - Signin/Sign out - log out buttns session -->

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
          <li><a href="../php/leaderboard.php">Leaderboard</a></li>
          <li><a href="../html/contact.php" class="active">>Contact</a></li>
        </ul>


      </div>
    </div>


  </nav>
  </header>

  <div class="team-container">
    <h2 class="team-title">Contact</h2>
    <hr>
    <br>
    <div>
      <p class="team-description">We are behind the checkers game for the CSCI 130 - Web Programming Class. </p>
    </div>
    <div class="team-members">
      <div class="team-member" id="maria-member">
        <img src="../images/maria1.jpeg" alt="Team Member 1">


        <!--Member Container-->


        <div class="member-info">

          <!--Member One - Maria-->
          <h3 style="color:#B1102B">Maria Guimaraes Diniz Tomaz</h3>
          <p>Senior Senior - FrontEnd | UX </p>
          <p>Student of Computer Science at <br> Fresno State</p><a href="https://github.com/maria1442"
            class="github-link" style="text-decoration: none;" target="_blank">
            <i class="fab fa-github"></i> GitHub
          </a>
          <br>
          <a href="https://www.linkedin.com/in/mariagdtomaz/" class="linkedin-link" style="text-decoration: none;"
            target="_blank">
            <i class="fab fa-linkedin"></i>LinkedIn
          </a>

        </div>
      </div>
      <div class="team-member">
        <!--Member two - Hue -->
        <img src="../images/hue.png" alt="Team Member 2">
        <div class="member-info">
          <h3 style="color:#B1102B">Hue Vang</h3>
          <p>Senior - FrontEnd | BackEnd</p>
          <p>Student of Computer Science at <br> Fresno State</p><a href="https://github.com/Hvang0702"
            class="github-link" style="text-decoration: none;" target="_blank">
            <i class="fab fa-github"></i> GitHub
          </a>
          <br>
          <a href="https://www.linkedin.com/in/huevang-profile/" class="linkedin-link" style="text-decoration: none;"
            target="_blank">
            <i class="fab fa-linkedin"></i>LinkedIn
          </a>
        </div>
      </div>
    </div>
  </div>
  </div>

</body>



</html>
<?php
session_start();

// Database connection details
include 'db_connection.php';
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT user_name, Name, password FROM users WHERE user_name = ?");
    $stmt->bind_param("s", $user_name);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_name'] = $user['user_name'];
        $_SESSION['name'] = $user['Name'];
        header('Location: ../php/main.php');
        exit();
    
    } else {
        $message = 'Incorrect username or password!';
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
    <link rel="icon" href="bb.png" type="image/png">
  <link rel="stylesheet" href="../css/styles.css">

  <style>
  

    .login-container {
      background-color: #ffffff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .login-form {
      display: flex;
      flex-direction: column;
      margin-top: 20px;
    }

    label {
      text-align: left;
      margin-bottom: 10px;
    }

    input {
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    button {
      background-color: #b1102b;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
    }

    button:hover {
      background-color: #b1102b;
    }

    .links {
      margin-top: 20px;
    }

    a {
      text-decoration: none;
      color: #b1102b;
      margin: 0 10px;
    }

    span {
      font-weight: bold;
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
  <!-- Your existing HTML structure -->
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

  <div class="login-container">
    <img src="bb.png" alt="Logo">
    <h2>Welcome Back Bulldog!</h2>
    
    <?php if (!empty($message)): ?>
        <p style="color: red;"><?php echo $message; ?></p>
    <?php endif; ?>

    <form class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <label for="user_name">User ID:</label>
      <input type="text" id="user_name" name="user_name" placeholder="User ID" required>

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" placeholder="Password" required>

      <button type="submit">Log In</button>
    </form>

    <div class="links">
      <a href="#">Forgot Password?</a>
      <br>
      <span>or</span>
      <br>
      <a href="../html/signUp.html">Doesn't Have an Account? Sign Up</a>
    </div>
  </div>

</body>
</html>


# Checkers Game  README

## Introduction

This Checkers Game web application provides a platform for users to play checkers in single and two player mode, view game rules, check leaderboards. It includes a login system for user authentication. This was developed as a project for the CSCI 130 - Web Programming class at CSU-Fresno. -This is the first version of the game- 

![]([https://github.com/Your_Repository_Name/Your_GIF_Name.gif](https://github.com/maria1442/CheckersGame/blob/main/Screen%20Recording%202023-12-14%20at%2011.45.17%20AM.mov))



## Important Links

- Figma Prototype: https://www.figma.com/proto/BB8WiVSJU1vUddbsIAmmqa/checkersGame?type=design&node-id=7-129&t=xfDcvKI1VORfENGL-0&scaling=contain&page-id=0%3A1&starting-point-node-id=7%3A129 

## Group Members 
| Team Member | Role |
---|---
| Hue Vue | Backend Developer|
| Maria Tomaz | FrontEnd Developer / UX/UI |


## Installation and Prerequisites

- PHP 
- MySQL 
- Apache
- XAMPP (includes all above)
- Web browser (e.g., Chrome, Firefox, Safari)

### Steps

1. **Clone Repository or Unzip Files**: 
   - If you have the project in a zip file, unzip it in your desired directory.
   -  Git repository, use `git clone <https://github.com/maria1442/CheckersGame.git>`.

2. **Configure Web Server**:
   - In XAMPP, set the project (checkersGame) folder  in the htdocs directory.
   
3. **Database Setup**:
   - Open the PHP file that establishes a database connection (`db_connection.php`), that will be found inside the  the `php`  directory.

   - Create the dabase and tables by running on your prefered browser: `http://localhost/create_db.php`

   - Update the database connection details (hostname, username, password, database name) to match your MySQL setup if needed.

## Usage

1. **Access the Application**:
   - Open your web browser and navigate to the web address where the project is hosted (e.g., `http://localhost` if you are running it locally).
    - Inside the folder **checkersGame** look for the main.php or main.html and you can start using the applciation 

2. **Login/Register**:
   - For first-time users, navigate to the 'Sign Up' page to create an account.
   - If you already have an account, use the 'Log In' page to access the application.
   - Login is not obligatory to play the game

3. **Playing the Game**:
   - Once logged in, navigate to the 'Home' section to start playing checkers.
   - Choose between different game modes and board sizes as provided.

4. **Viewing Leaderboards and Game Rules**:
   - Use the navigation bar to switch between different sections of the application, such as the Leaderboard, How to Play, and Contact pages.

5. **Logging Out**:
   - Click on the 'Logout' button in the navigation bar to end your session.
  
   ## Future Features

   The game still under development and future features will be posted. 


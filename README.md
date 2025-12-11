# Online Tic-Tac-Toe Game

This is a modern, real-time, browser-based implementation of the classic Tic-Tac-Toe game (also known as Noughts and Crosses). Built with PHP, MySQL, and leveraging AJAX for real-time updates, it provides a seamless, two-player experience.

## ✨ Features Overview

| Feature | Description |
| :--- | :--- |
| **User Authentication** | Secure login and user session management. |
| **Game Lobby** | Central hub for creating and joining games. |
| **Real-Time Gameplay** | AJAX polling ensures the board and status update instantly for both players. | 
| **Player Roles** | Clearly defined Player X (Creator) and Player O (Joiner). |
| **Status Tracking** | Tracks game states: WAITING, IN_PROGRESS, X_WINS, O_WINS, DRAW. |
| **Modern UI** | Clean, focused, and responsive layout using Bootstrap 5. |

## 🕹️ Key Features in Detail

### 1. Game Lobby

The Lobby serves as the central navigation hub for all players. It allows users to manage their existing games and find new opponents.

* **Create Game Session:** Instantly create a new game as **Player X** and wait for an opponent.
* **Available Games to Join:** Browse a list of all games currently in the `WAITING` status, created by other users. Join these games instantly as **Player O**.
* **Your Games:** A dedicated list showing all games you are currently participating in, regardless of status (Waiting, In Progress, or Finished).



### 2. Real-Time Gameplay Board

The core game screen is designed to be highly focused, minimizing distractions and maximizing the board visibility.

* **Responsive Board:** The 3x3 game board is centrally located and adjusts to different screen sizes while maintaining the modern, compact aesthetic.
    
* **Opponent Tracking:** Clearly displays the names and roles (X vs O) of both players.
* **Dynamic Status Indicator:** A prominent alert box provides immediate feedback on the game state:
    * `WAITING`: Waiting for a second player to join.
    * `🎯 Your Turn`: Prompts the current user to make a move.
    * `⏳ Opponent's Turn`: Informs the user they must wait for the opponent.
    * `X WINS` / `O WINS` / `DRAW`: Displays the final outcome.
    

## 🛠️ Technology Stack

* **Backend:** PHP (Handles all game logic, state management, and database interactions).
* **Database:** MySQL (Stores user accounts and game states).
* **Frontend:** HTML5, Bootstrap 5 (For responsive layout and modern components).
* **Interactivity:** jQuery & AJAX (Used for real-time polling to update the board without refreshing the page).
* **Architecture:** Follows a simple MVC (Model-View-Controller) pattern with separate files for database actions, API endpoints, and views.

## ⚙️ Installation and Setup (Self-Hosting)

To run Connect-X on your own server (e.g., InfinityFree, XAMPP, or MAMP), follow these steps:

### Prerequisites

* Web server with PHP 7.4+
* MySQL/MariaDB database
* PHP PDO extension enabled

### Setup Steps

1.  **Clone the Repository:**
    ```bash
    git clone https://github.com/rajesh-mondal/tic-tac-toe-php
    cd tic-tac-toe-php
    ```

2.  **Database Setup:**
    * Create a MySQL database named `tic-tac-toe`
    * Import the SQL schema file (`database.sql`) to create the `users` and `games` tables.
    * Update your database connection file (e.g., `config/db.php` or similar) with your host, username, and password:

        ```
        const DB_HOST = 'localhost';
        const DB_NAME = 'tic-tac-toe';
        const DB_USER = 'root';
        const DB_PASS = '';
        ```

3.  **Deployment:**
    * Upload all project files to your web server's root directory (`htdocs` or `public_html`).

4.  **Run:**
    * Navigate to your project URL (e.g., `http://localhost/tic-tac-toe-php/` or `http://yourdomain.com/index.php`).

## ✍️ Development Status

This project is stable and fully functional for basic 3x3 Tic-Tac-Toe. Future plans may include:
* Implementing chat functionality.
* Using WebSockets for true real-time push notifications instead of polling.

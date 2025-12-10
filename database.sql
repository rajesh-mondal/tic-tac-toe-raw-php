-- database.sql

-- User Table (for identification)
CREATE TABLE users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

-- Games Table (for state management)
CREATE TABLE games (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    player_x_id INT(11) UNSIGNED NULL,
    player_o_id INT(11) UNSIGNED NULL,
    board_state VARCHAR(9) DEFAULT '---------' NOT NULL COMMENT '9 chars: X, O, or -',
    current_turn CHAR(1) DEFAULT 'X' NOT NULL,
    status ENUM('WAITING', 'IN_PROGRESS', 'X_WINS', 'O_WINS', 'DRAW') DEFAULT 'WAITING' NOT NULL
);
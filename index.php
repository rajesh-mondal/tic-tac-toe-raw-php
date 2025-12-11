<?php

session_start();
require_once 'config/db.php';

$conn = getDbConnection();

// Handle POST Actions
if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
    // Handle Login/Name Entry
    if ( isset( $_POST['name'] ) ) {
        $name = trim( $_POST['name'] );
        if ( !empty( $name ) ) {
            $stmt = $conn->prepare( "INSERT INTO users (name) VALUES (:name)" );
            $stmt->execute( [':name' => $name] );
            $_SESSION['user_id'] = $conn->lastInsertId();
            $_SESSION['user_name'] = $name;
            header( 'Location: index.php' );
            exit;
        }
    }

    if ( !isset( $_SESSION['user_id'] ) ) {header( 'Location: index.php' );exit;}
    $user_id = $_SESSION['user_id'];

    // Create Game
    if ( isset( $_POST['action'] ) && $_POST['action'] === 'create' ) {
        $stmt = $conn->prepare( "INSERT INTO games (player_x_id) VALUES (:user_id)" );
        $stmt->execute( [':user_id' => $user_id] );
        $game_id = $conn->lastInsertId();
        header( "Location: index.php?game=$game_id" );
        exit;
    }

    // Join Game
    if ( isset( $_POST['action'] ) && $_POST['action'] === 'join' && isset( $_POST['game_id'] ) ) {
        $game_id = (int) $_POST['game_id'];

        $stmt = $conn->prepare( "
            UPDATE games
            SET player_o_id = :user_id, status = 'IN_PROGRESS'
            WHERE id = :game_id AND status = 'WAITING' AND player_x_id != :user_id
        " );
        $stmt->execute( [':user_id' => $user_id, ':game_id' => $game_id] );

        $redirect_url = ( $stmt->rowCount() > 0 ) ? "index.php?game=$game_id" : "index.php?error=join_failed";
        header( "Location: $redirect_url" );
        exit;
    }
}

// View Router
// Show Login View
if ( !isset( $_SESSION['user_id'] ) ) {
    require 'views/login.php';
    exit;
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// Show Game Board View
if ( isset( $_GET['game'] ) ) {
    // Pass essential data to the view before requiring it
    $game_id = (int) $_GET['game'];

    // Fetch game data to validate access before showing the view
    $stmt = $conn->prepare( "
        SELECT g.*, u_x.name as player_x_name, u_o.name as player_o_name
        FROM games g
        JOIN users u_x ON g.player_x_id = u_x.id
        LEFT JOIN users u_o ON g.player_o_id = u_o.id
        WHERE g.id = :game_id
    " );
    $stmt->execute( [':game_id' => $game_id] );
    $game = $stmt->fetch( PDO::FETCH_ASSOC );

    $user_id = $_SESSION['user_id'];

    // Authorization Check
    if ( !$game || ( $game['player_x_id'] != $user_id && $game['player_o_id'] != $user_id ) ) {
        header( 'Location: index.php?error=access_denied' );
        exit;
    }

    require 'views/game_board.php';
    exit;
}

// Show Lobby View
require 'views/lobby.php';

?>
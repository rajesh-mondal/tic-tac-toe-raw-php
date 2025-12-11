<?php

session_start();
header( 'Content-Type: application/json' );
require_once '../config/db.php';

$response = ['success' => false, 'game' => null];

if ( !isset( $_GET['game_id'] ) ) {
    http_response_code( 400 );
    $response['message'] = 'Missing game ID.';
    echo json_encode( $response );
    exit;
}

$game_id = (int) $_GET['game_id'];
$conn = getDbConnection();

try {
    $stmt = $conn->prepare( "SELECT id, player_x_id, player_o_id, board_state, current_turn, status FROM games WHERE id = :game_id" );
    $stmt->execute( [':game_id' => $game_id] );
    $game = $stmt->fetch( PDO::FETCH_ASSOC );

    if ( $game ) {
        $response['success'] = true;
        $response['game'] = $game;
    }
} catch ( Exception $e ) {
    error_log( "Game state error: " . $e->getMessage() );
    $response['message'] = 'Internal server error.';
}

echo json_encode( $response );
<?php

session_start();
header( 'Content-Type: application/json' );
require_once '../config/db.php';
require_once '../includes/GameLogic.php';

$response = ['success' => false, 'message' => ''];

if ( !isset( $_POST['game_id'], $_POST['user_id'], $_POST['move_index'] ) || $_POST['user_id'] != $_SESSION['user_id'] ) {
    $response['message'] = 'Invalid request or session mismatch.';
    echo json_encode( $response );
    exit;
}

$game_id = (int) $_POST['game_id'];
$user_id = (int) $_POST['user_id'];
$move_index = (int) $_POST['move_index'];
$conn = getDbConnection();

try {
    // Fetch current game state
    $stmt = $conn->prepare( "SELECT * FROM games WHERE id = :id" );
    $stmt->execute( [':id' => $game_id] );
    $game = $stmt->fetch( PDO::FETCH_ASSOC );

    if ( !$game || $game['status'] !== 'IN_PROGRESS' ) {
        $response['message'] = 'Game not available or finished.';
        echo json_encode( $response );
        exit;
    }

    $player_role = ( $game['player_x_id'] == $user_id ) ? 'X' : ( ( $game['player_o_id'] == $user_id ) ? 'O' : null );

    // Validate move
    if ( $player_role === null || $game['current_turn'] !== $player_role || $game['board_state'][$move_index] !== '-' ) {
        $response['message'] = 'Invalid move (not your turn or cell occupied).';
        echo json_encode( $response );
        exit;
    }

    // Update state and check status
    $new_board_state = substr_replace( $game['board_state'], $player_role, $move_index, 1 );
    $new_status = checkGameStatus( $new_board_state );
    $next_turn = ( $new_status === 'IN_PROGRESS' ) ? ( $player_role === 'X' ? 'O' : 'X' ) : $game['current_turn'];

    // Update the database
    $stmt = $conn->prepare( "
        UPDATE games
        SET board_state = :board_state, current_turn = :current_turn, status = :status
        WHERE id = :id
    " );
    $stmt->execute( [
        ':board_state'  => $new_board_state,
        ':current_turn' => $next_turn,
        ':status'       => $new_status,
        ':id'           => $game_id,
    ] );

    $response['success'] = true;

} catch ( Exception $e ) {
    error_log( "Move processing error: " . $e->getMessage() );
    $response['message'] = 'Internal server error.';
}

echo json_encode( $response );
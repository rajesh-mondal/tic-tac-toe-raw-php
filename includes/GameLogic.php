<?php

// Checks the board for a win or a draw.
function checkGameStatus( string $board_state ): string {
    // Winning combinations
    $winning_combos = [
        [0, 1, 2], [3, 4, 5], [6, 7, 8], // Rows
        [0, 3, 6], [1, 4, 7], [2, 5, 8], // Columns
        [0, 4, 8], [2, 4, 6], // Diagonals
    ];

    // Check for Win
    foreach ( $winning_combos as $combo ) {
        $c1 = $board_state[$combo[0]];
        $c2 = $board_state[$combo[1]];
        $c3 = $board_state[$combo[2]];

        if ( $c1 !== '-' && $c1 === $c2 && $c2 === $c3 ) {
            return $c1 === 'X' ? 'X_WINS' : 'O_WINS';
        }
    }

    // Check for Draw
    if ( strpos( $board_state, '-' ) === false ) {
        return 'DRAW';
    }

    // Game is still in progress
    return 'IN_PROGRESS';
}
<?php

$is_player_x = ( $game['player_x_id'] == $user_id );
$is_player_o = ( $game['player_o_id'] == $user_id );
$current_player_role = $is_player_x ? 'X' : ( $is_player_o ? 'O' : null );
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game #<?=$game_id?> | Connect-X</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        .board-grid {
            display: grid; grid-template-columns: repeat(3, 100px); grid-template-rows: repeat(3, 100px);
            gap: 5px; margin: 20px auto; width: 310px;
        }
        .cell {
            background-color: #fff; border: 3px solid #3498db; display: flex; align-items: center;
            justify-content: center; font-size: 40px; font-weight: bold; cursor: pointer; transition: background-color 0.2s;
        }
        .cell:hover:not(.disabled):not(.filled) { background-color: #ecf0f1; }
        .cell.disabled { cursor: not-allowed; opacity: 0.8; }
        .cell.filled { cursor: default; }
        .cell.X { color: #e74c3c; } .cell.O { color: #2ecc71; }
        .game-info { height: 70px; }
    </style>
</head>
<body class="bg-light">
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="text-center text-primary mb-4">⚔️ Game Session #<?=$game_id?></h1>

                <div class="card shadow">
                    <div class="card-header text-center bg-dark text-white">
                        <span class="badge bg-danger">X: <?=htmlspecialchars( $game['player_x_name'] )?></span>
                        vs
                        <span class="badge bg-success">O: <?=htmlspecialchars( $game['player_o_name'] ?? 'Waiting...' )?></span>
                    </div>
                    <div class="card-body">

                        <div class="game-info text-center d-flex align-items-center justify-content-center mb-3">
                            <div id="game-status" class="alert alert-info w-75 mb-0">Initializing...</div>
                        </div>

                        <div class="board-grid" id="board">
                            <?php for ( $i = 0; $i < 9; $i++ ): ?>
                                <div class="cell" data-index="<?=$i?>"></div>
                            <?php endfor; ?>
                        </div>

                        <div class="text-center mt-4">
                            <a href="index.php" class="btn btn-secondary me-2">Back to Lobby</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const GAME_ID = <?=$game_id?>;
        const USER_ID = <?=$user_id?>;
        const USER_ROLE = '<?=$current_player_role?>';
        let isMyTurn = false;
        let gameStatus = '<?=$game['status']?>';
        let boardState = '<?=$game['board_state']?>';

        // Core Game Functions

        function renderBoard() {  }
        function updateUI(data) {  }

        function pollGameState() {
            $.ajax({
                url: 'api/get_state.php',
                type: 'GET',
                dataType: 'json',
                data: { game_id: GAME_ID },
                success: function(response) {
                    if (response.success) {
                        updateUI(response.game);
                    }
                },
                error: function(xhr, status, error) { console.error("Polling error:", error); }
            });
        }

        pollGameState();
        setInterval(pollGameState, 2000);

        $('#board').on('click', '.cell:not(.disabled)', function() {
            if (!isMyTurn || gameStatus !== 'IN_PROGRESS') return;

            const cellIndex = $(this).data('index');

            $(this).text(USER_ROLE).addClass(USER_ROLE + ' filled disabled');
            isMyTurn = false;
            $('#game-status').removeClass().addClass('alert alert-info w-75 mb-0').html(`⏳ Opponent's Turn...`);

            // Send move to server
            $.ajax({
                url: 'api/make_move.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    game_id: GAME_ID,
                    user_id: USER_ID,
                    move_index: cellIndex
                },
                success: function(response) {
                    if (!response.success) {
                        pollGameState();
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('Server communication error.');
                    pollGameState();
                }
            });
        });

    </script>
</body>
</html>
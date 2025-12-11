<?php

$user_name = $_SESSION['user_name'];

// Fetch available games
$stmt = $conn->prepare( "
    SELECT g.id, u.name as player_x_name
    FROM games g
    JOIN users u ON g.player_x_id = u.id
    WHERE g.status = 'WAITING' AND g.player_x_id != :user_id
" );
$stmt->execute( [':user_id' => $user_id] );
$waiting_games = $stmt->fetchAll( PDO::FETCH_ASSOC );

// Fetch my games
$stmt = $conn->prepare( "
    SELECT id, status
    FROM games
    WHERE player_x_id = :user_id OR player_o_id = :user_id
    ORDER BY status DESC, id DESC
" );
$stmt->execute( [':user_id' => $user_id] );
$my_games = $stmt->fetchAll( PDO::FETCH_ASSOC );
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connect-X Lobby</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container my-5">
        <h1 class="text-center text-primary mb-4">Welcome, <?=htmlspecialchars( $user_name )?>!</h1>
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white"><h5 class="mb-0">Create New Game</h5></div>
                    <div class="card-body text-center">
                        <p>Start a new game as **Player X**.</p>
                        <form method="POST" action="index.php"><input type="hidden" name="action" value="create">
                            <button type="submit" class="btn btn-success btn-lg w-75">Create Game Session</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white"><h5 class="mb-0">Available Games to Join</h5></div>
                    <div class="card-body p-0">
                        <?php if ( count( $waiting_games ) > 0 ): ?>
                            <table class="table table-hover mb-0">
                                <thead><tr><th>ID</th><th>Creator (X)</th><th>Action</th></tr></thead>
                                <tbody>
                                    <?php foreach ( $waiting_games as $game ): ?>
                                        <tr>
                                            <td>#<?=$game['id']?></td>
                                            <td><?=htmlspecialchars( $game['player_x_name'] )?></td>
                                            <td>
                                                <form method="POST" action="index.php" class="d-inline">
                                                    <input type="hidden" name="action" value="join">
                                                    <input type="hidden" name="game_id" value="<?=$game['id']?>">
                                                    <button type="submit" class="btn btn-sm btn-outline-primary">Join (as O)</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p class="p-3 text-center text-muted mb-0">No games waiting.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <h3 class="mt-5 mb-3 text-center">Your Games</h3>
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <?php if ( count( $my_games ) > 0 ): ?>
                    <table class="table table-striped mb-0">
                        <thead><tr><th>Game ID</th><th>Status</th><th>Action</th></tr></thead>
                        <tbody>
                            <?php foreach ( $my_games as $game ): ?>
                                <tr>
                                    <td>#<?=$game['id']?></td>
                                    <td><span class="badge bg-primary"><?=str_replace( '_', ' ', $game['status'] )?></span></td>
                                    <td><a href="index.php?game=<?=$game['id']?>" class="btn btn-sm btn-primary">View/Play</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="p-3 text-center text-muted mb-0">You have no games.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
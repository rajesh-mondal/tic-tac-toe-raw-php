<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connect-X: Sign In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #e9ecef; }
        .card { max-width: 400px; margin-top: 100px; border-radius: 12px; }
        .card-header {
            background-color: #007bff;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card shadow-lg mx-auto">
            <div class="card-header bg-primary text-white text-center">
                <h1 class="h3 mb-0 py-2">Tic-Tac-Toe</h1>
            </div>
            <div class="card-body p-4">
                <p class="card-text text-center text-muted">Enter your name to play.</p>
                <form method="POST" action="index.php">
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Your Player Name</label>
                        <input type="text" class="form-control form-control-lg" id="name" name="name" required maxlength="50" placeholder="e.g., Alice">
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100 mt-3 shadow-sm">
                        Go to Lobby
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
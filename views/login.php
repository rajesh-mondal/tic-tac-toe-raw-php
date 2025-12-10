
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connect-X: Simple Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body { background-color: #f8f9fa; }.card { max-width: 400px; margin-top: 100px; }</style>
</head>
<body>
    <div class="container">
        <div class="card shadow mx-auto">
            <div class="card-header bg-primary text-white text-center"><h1 class="h3 mb-0">🚀 Connect-X</h1></div>
            <div class="card-body">
                <p class="card-text text-center">Enter your name to start!</p>
                <form method="POST" action="index.php">
                    <div class="mb-3">
                        <label for="name" class="form-label">Your Name</label>
                        <input type="text" class="form-control" id="name" name="name" required maxlength="50">
                    </div>
                    <button type="submit" class="btn btn-success w-100">Go to Lobby</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
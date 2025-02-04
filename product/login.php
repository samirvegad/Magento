<?php
session_start();  // Ensure session is started
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .login-container {
            max-width: 600px;
            width: 100%;
            padding: 20px;
        }
        .form-control {
            border: none; 
            border-bottom: 2px solid #6c757d; 
            border-radius: 0; 
            box-shadow: none;  
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
        
    <div class="login-container card shadow p-4">
        <h2 class="text-center">Login</h2>

        <!-- Display error message if there is any -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $_SESSION['error']; ?>
            </div>
            <?php unset($_SESSION['error']); ?> <!-- Clear the error after displaying -->
        <?php endif; ?>

        <form action="process_login.php" method="POST">
            <div class="mb-3">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <p class="text-center mt-3">Don't have an account? <a href="register.php">Register here</a></p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

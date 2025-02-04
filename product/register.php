<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .register-container {
            max-width: 700px;
            width: 100%;
            padding: 20px;
        }
        .form-control {
            border: none; 
            border-bottom: 2px solid #6c757d; 
            border-radius: 0; 
            box-shadow: none;  
        }
        .error-message {
            color: red;
            font-size: 14px;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center mt-5 bg-light">
    <div class="register-container card shadow p-4">
        <h2 class="text-center">Register</h2>
        <form action="process_register.php" method="POST" enctype="multipart/form-data" id="registerForm">
            <div class="mb-3">
                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter First name" required>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Last name" required>
            </div>
            <div class="mb-3">
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Enter Confirm password" required>
                <div id="error_message" class="error-message"></div> <!-- Error message for mismatch -->
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address" required>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" id="city" name="city" placeholder="Enter City" required>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" id="country" name="country" placeholder="Enter Country" required>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Number" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Profile Picture:</label>
                <input type="file" class="form-control" id="image" name="image" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
        <p class="text-center mt-3">Already have an account? <a href="login.php">Login here</a></p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Form Validation on Submit
        document.getElementById('registerForm').addEventListener('submit', function(event) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const errorMessage = document.getElementById('error_message');

            // Check if passwords match
            if (password !== confirmPassword) {
                // Prevent form submission
                event.preventDefault();

                // Display error message
                errorMessage.textContent = "Passwords do not match. Please try again.";
            } else {
                // Clear error message if passwords match
                errorMessage.textContent = '';
            }
        });
    </script>
</body>
</html>

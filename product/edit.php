<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('config.php');
$user_id = $_SESSION['user_id'];

// Fetch the current user data from the database
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Close the database connection
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-control {
            border: none;
            border-bottom: 2px solid #6c757d;
            border-radius: 0;
            box-shadow: none;
        }
        .profile-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center  mt-5 bg-light">
    <div class="container">
        <div class="card shadow p-4">
            <h2 class="text-center">Edit Profile</h2>
            <form action="update.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">

                <!-- First Name -->
                <div class="mb-3">
                    <input type="text" class="form-control" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
                </div>

                <!-- Last Name -->
                <div class="mb-3">
                    <input type="text" class="form-control" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>

                <!-- Address -->
                <div class="mb-3">
                    <input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" required>
                </div>

                <!-- City -->
                <div class="mb-3">
                    <input type="text" class="form-control" name="city" value="<?php echo htmlspecialchars($user['city']); ?>" required>
                </div>

                <!-- Country -->
                <div class="mb-3">
                    <input type="text" class="form-control" name="country" value="<?php echo htmlspecialchars($user['country']); ?>" required>
                </div>

                <!-- Phone -->
                <div class="mb-3">
                    <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                </div>

                <!-- Profile Image -->
                <div class="mb-3">
                    <label for="image" class="form-label">Profile Picture:</label>
                    <input type="file" class="form-control" name="image">
                    <p>Current Image:</p>
                    <img src="uploads/<?php echo $user['image']; ?>" alt="Profile Image" class="profile-img">
                </div>

                <button type="submit" class="btn btn-primary w-100">Update Profile</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

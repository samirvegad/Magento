<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('config.php');
$user_id = $_SESSION['user_id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $status = $_POST['status'];
    $image = '';

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imageName = time() . '_' . $_FILES['image']['name'];
        $imagePath = 'uploads/' . $imageName;

        // Move the uploaded file to the "uploads" folder
        if (move_uploaded_file($imageTmpName, $imagePath)) {
            $image = $imagePath;
        }
    }

    // Insert product into the database
    $sql = "INSERT INTO products (user_id, name, title, description, price, image, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssdss", $user_id, $name, $title, $description, $price, $image, $status);
    $stmt->execute();
    header("Location: product_page.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container {
            max-width: 800px;
            margin: 50px auto;
        }
    </style>
</head>
<body>
    <!-- Include Navbar -->
    <?php include('navbar.php'); ?>

    <div class="container form-container">
        <h2 class="text-center mb-4">Add New Product</h2>
        <form action="add_product.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Product Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Product Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Product Price</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Product Image</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Product Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="enable">Enabled</option>
                    <option value="disable">Disabled</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success w-100">Add Product</button>
        </form>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; 2025 MyWebsite. All Rights Reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

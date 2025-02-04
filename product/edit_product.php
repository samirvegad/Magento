<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('config.php');
$user_id = $_SESSION['user_id'];

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch the product details from the database
    $sql = "SELECT * FROM products WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $product_id, $user_id);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();

    if (!$product) {
        die("Product not found or you don't have permission to edit it.");
    }
} else {
    die("Product ID is missing.");
}

// Handle form submission for updating the product
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $status = $_POST['status'];
    $image = $product['image']; // Keep the old image by default

    // Handle image upload if a new image is provided
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imageName = time() . '_' . $_FILES['image']['name'];
        $imagePath = 'uploads/' . $imageName;

        // Move the uploaded file to the "uploads" folder
        if (move_uploaded_file($imageTmpName, $imagePath)) {
            $image = $imagePath;
        }
    }

    // Update product details in the database
    $sql = "UPDATE products SET name = ?, title = ?, description = ?, price = ?, status = ?, image = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssii", $name, $title, $description, $price, $status, $image, $product_id, $user_id);
    $stmt->execute();

    // Redirect to the product page after successful update
    header("Location: product_page.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
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
        <h2 class="text-center mb-4">Edit Product</h2>
        <form action="edit_product.php?id=<?php echo $product['id']; ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Product Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($product['title']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Product Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Product Price</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Product Image (Optional)</label>
                <input type="file" class="form-control" id="image" name="image">
                <?php if ($product['image']): ?>
                    <div class="mt-2">
                        <strong>Current Image:</strong>
                        <img src="<?php echo $product['image']; ?>" alt="Product Image" width="100" height="100" class="img-fluid">
                    </div>
                <?php else: ?>
                    <p>No Image</p>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Product Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="enable" <?php echo $product['status'] == 'enable' ? 'selected' : ''; ?>>Enabled</option>
                    <option value="disable" <?php echo $product['status'] == 'disable' ? 'selected' : ''; ?>>Disabled</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success w-100">Update Product</button>
        </form>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; 2025 MyWebsite. All Rights Reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

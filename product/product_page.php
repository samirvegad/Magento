<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('config.php');
$user_id = $_SESSION['user_id'];

// Fetch user details
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Fetch products for the logged-in user
$sql = "SELECT * FROM products WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$products = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table td, .table th {
            vertical-align: middle;
        }

        .table img {
            border-radius: 8px;
        }

        .badge-enabled {
            background-color: green;
        }

        .badge-disabled {
            background-color: red;
        }

        .table-striped tbody tr:nth-child(odd) {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <!-- Include Navbar -->
    <?php include('navbar.php'); ?>

    <div class="container mt-5">
       
        <a href="add_product.php" class="btn btn-primary mb-3">Add Product</a>

       
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                        <?php while ($product = $products->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <?php if ($product['image']): ?>
                                        <img src="<?php echo $product['image']; ?>" alt="Product Image" width="100" height="100" class="img-fluid">
                                    <?php else: ?>
                                        <span>No Image</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $product['name']; ?></td>
                                <td><?php echo $product['title']; ?></td>
                                <td><?php echo $product['description']; ?></td>
                                <td><?php echo "<i class='fa-solid fa-indian-rupee-sign'></i> " . number_format($product['price'], 2); ?></td>
                                <td>
                                    <?php if ($product['status'] === 'enable'): ?>
                                        <span class="badge badge-enabled">Enabled</span>
                                    <?php else: ?>
                                        <span class="badge badge-disabled">Disabled</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <!-- Edit and Delete Icons -->
                                    <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                </td>
                                <td>
                                    <a href="delete_product.php?id=<?php echo $product['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?');"><i class="fas fa-trash-alt"></i> Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; 2025 MyWebsite. All Rights Reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

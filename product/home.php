<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('config.php');
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Fetch only enabled products to display on the homepage
$product_sql = "SELECT * FROM products WHERE user_id = ? AND status = 'enable'";
$product_stmt = $conn->prepare($product_sql);
$product_stmt->bind_param("i", $user_id);
$product_stmt->execute();
$products = $product_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Include Navbar -->
    <?php include('navbar.php'); ?>

    <!-- Carousel -->
    <div class="container mt-4">
        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="./image/slider1.jpg" class="d-block w-100" style="height:500px" alt="Slide 1">
                </div>
                <div class="carousel-item">
                    <img src="./image/slider2.jpg" class="d-block w-100" style="height:500px" alt="Slide 2">
                </div>
                <div class="carousel-item">
                    <img src="./image/slider3.jpg" class="d-block w-100" style="height:500px" alt="Slide 3">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>
        </div>
    </div>

    <!-- Product Cards -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Our Products</h2>
        <div class="row">
            <?php while ($product = $products->fetch_assoc()): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <!-- Display Product Image -->
                    <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="Product Image" style="height: 250px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $product['name']; ?></h5>
                        <p class="card-text"><?php echo $product['description']; ?></p>
                        <p class="card-text"><strong>
                        <i class="fa-solid fa-indian-rupee-sign"></i>    
                        <?php echo number_format($product['price'], 2); ?></strong></p>
                        <a href="#" class="btn btn-primary">Add to Cart</a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; 2025 MyWebsite. All Rights Reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

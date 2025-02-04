<?php
// Start the session
session_start();

// Include the database connection file
include('config.php');

// Query to fetch all users
$sql_users = "SELECT * FROM users";
$result_users = $conn->query($sql_users);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a>
                <img src="./image/logo.png" alt="Logo" width="100" height="auto">
            </a>
            <div class="ml-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-primary">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Image Slider -->
    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="./image/slider1.jpg" class="d-block w-100" style="height: 500px;" alt="Slide 1">
            </div>
            <div class="carousel-item">
                <img src="./image/slider2.jpg" class="d-block w-100" style="height: 500px;" alt="Slide 2">
            </div>
            <div class="carousel-item">
                <img src="./image/slider3.jpg" class="d-block w-100" style="height: 500px;" alt="Slide 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>

    <!-- Main Content -->
    <div class="container mt-5">
    <h2 class="text-center mb-4">All Products</h2>

    <?php
    // Query to fetch all products from all users
    $sql_products = "SELECT * FROM products";
    $result_products = $conn->query($sql_products);

    // Counter to ensure 3 products per row
    $counter = 0;
    ?>

    <div class="row">
        <?php while ($product = $result_products->fetch_assoc()): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <!-- Display Product Image -->
                    <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="Product Image" style="height: 250px; object-fit: cover;">
                    <div class="card-body">
                        <!-- Display Product Name -->
                        <h5 class="card-title"><?php echo $product['name']; ?></h5>
                        <!-- Display Product Description -->
                        <p class="card-text"><?php echo $product['description']; ?></p>
                        <!-- Display Product Price -->
                        <p class="card-text"><strong>$<?php echo number_format($product['price'], 2); ?></strong></p>
                    </div>
                </div>
            </div>

            <?php
            // Increment counter
            $counter++;

            // If counter reaches 3, close the current row and start a new one
            if ($counter % 3 == 0): ?>
                </div> <!-- Close current row -->
                <div class="row"> <!-- Start new row -->
            <?php endif; ?>
        <?php endwhile; ?>

        <!-- Close any remaining open row tag after finishing the loop -->
        <?php if ($counter % 3 != 0): ?>
            </div> <!-- Close row -->
        <?php endif; ?>
    </div>
</div>


    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; 2025 MyWebsite. All Rights Reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

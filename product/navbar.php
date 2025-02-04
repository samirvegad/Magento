<!-- navbar.php -->
<style>
    /* Style for the profile image circle */
    .profile-img {
        width: 40px;          
        height: 40px;          
        border-radius: 50%;    
        object-fit: cover;     
    }
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<!-- navbar.php -->
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
    <div class="container">
        <!-- Logo and Home Link -->
        <a class="navbar-brand">
            <img src="./image/logo.png" alt="Logo" width="100" height="auto">
        </a>
        <div class=" navbar-collapse" >
            <ul class="navbar-nav ms-auto"> <!-- Use ms-auto to push items to the right -->
                <li class="nav-item">
                    <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'home.php') ? 'active' : ''; ?>" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'product_page.php') ? 'active' : ''; ?>" href="product_page.php">Product</a>
                </li>
            </ul>
            <!-- Profile Image and Dropdown on the Right -->
            <div class="dropdown ms-auto"> <!-- ms-auto ensures it's aligned to the right -->
                <img src="uploads/<?php echo $user['image']; ?>" alt="Profile Image" class="profile-img" data-bs-toggle="dropdown" aria-expanded="false">
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="edit.php">Edit</a></li>
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>


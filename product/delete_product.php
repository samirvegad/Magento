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

    $sql = "SELECT image FROM products WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $product_id, $user_id);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();

    // Check if the product exists
    if (!$product) {
        die("Product not found or you don't have permission to delete it.");
    }

    $sql = "DELETE FROM products WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $product_id, $user_id);
    $stmt->execute();

    if ($product['image'] && file_exists($product['image'])) {
        unlink($product['image']); 
    }

    header("Location: product_page.php");
    exit();
} else {
    die("Product ID is missing.");
}
?>

<?php
session_start();  // Make sure the session is started

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['email'];
    $password = $_POST['password'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'user_management');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prevent SQL Injection by using prepared statements
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username); // "s" for string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password (consider using password_hash() and password_verify() for real-world applications)
        if ($user && $user['password'] === $password) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: product_page.php");
            exit();
        } else {
            $_SESSION['error'] = 'Invalid username or password';
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['error'] = 'No user found with that email address';
        header("Location: login.php");
        exit();
    }

    $conn->close();
} else {
    // If someone tries to access this page directly, redirect to login page
    header("Location: login.php");
    exit();
}

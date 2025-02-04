<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $phone = $_POST['phone'];

    // Image Upload
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    move_uploaded_file($image_tmp, "uploads/$image");

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'user_management');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO users (first_name, last_name, email, password, address, city, country, phone, image)
            VALUES ('$first_name', '$last_name', '$email', '$password', '$address', '$city', '$country', '$phone', '$image')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
        header("Location: login.php");
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>

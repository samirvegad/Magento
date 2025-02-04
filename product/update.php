<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('config.php');
    
    $user_id = $_POST['user_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $phone = $_POST['phone'];

    // If a new image is uploaded, handle the image update
    if ($_FILES['image']['name']) {
        $image = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_path = "uploads/" . basename($image);

        // Move the uploaded image to the desired directory
        move_uploaded_file($image_tmp, $image_path);
    } else {
        // Keep the current image if no new image is uploaded
        $sql = "SELECT image FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $image = $user['image'];
        $stmt->close();
    }

    // Update the user information in the database
    $sql = "UPDATE users SET 
                first_name = ?, 
                last_name = ?, 
                email = ?, 
                address = ?, 
                city = ?, 
                country = ?, 
                phone = ?, 
                image = ? 
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssi", $first_name, $last_name, $email, $address, $city, $country, $phone, $image, $user_id);

    if ($stmt->execute()) {
        header("Location: product_page.php");
        exit();
    } else {
        echo "Error updating profile: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

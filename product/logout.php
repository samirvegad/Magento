<?php
session_start(); // Start the session

// Destroy the session
session_destroy();

// Redirect to the login page after logout
header("Location: login.php");
exit();
?>
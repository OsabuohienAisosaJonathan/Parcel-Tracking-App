<?php
session_start();

// Default admin credentials
$admin_email = "admin@courierx.com";
$admin_password = "SecurePass123";

// Initialize error message
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"] ?? '';
    $password = $_POST["password"] ?? '';

    if ($email === $admin_email && $password === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: dashboard/dashb.php");
        exit();
    } else {
        $error = "Invalid login credentials.";
    }
}
?>
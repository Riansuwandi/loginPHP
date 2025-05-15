<?php
session_start();
require_once 'config.php';

$username = $_POST['username'];
$password = $_POST['password'];

// Fetch user by username
    $stmt = $conn->prepare("SELECT password, email, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

if ($user && password_verify($password, $user['password'])) {
    // Login successful, set session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    header("Location: ../dashboard.php"); // Redirect to protected area
    exit;
} else {
    $error = "Username atau password salah.";
    header("Location: ../login.php?error=" . urlencode($error));
    exit;
}
?>
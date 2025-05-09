<?php
require_once 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $role = 'user'; // default role

    // Cek apakah username sudah digunakan
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['error'] = "Username sudah digunakan. Silakan pilih yang lain.";
        header("Location: register.php");
        exit;
    }

    // Cek apakah password dan konfirmasi cocok
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Password dan konfirmasi password tidak sama.";
        header("Location: register.php");
        exit;
    }

    // Hash password sebelum disimpan
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Simpan user ke database
    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $hashed_password, $role);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
        header("Location: login.php?success=1");
        exit;
    } else {
        $_SESSION['error'] = "Terjadi kesalahan saat registrasi. Silakan coba lagi.";
        header("Location: register.php");
        exit;
    }
}
?>

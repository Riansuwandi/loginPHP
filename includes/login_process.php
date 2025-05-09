<?php
session_start();
require_once 'config.php'; // pastikan config.php menyambung ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validasi input kosong
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Username dan password wajib diisi.";
        header("Location: login.php");
        exit;
    }

    // Ambil data user dari database
    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Perilaku ketika username tidak ditemukan
    if ($result->num_rows === 0) {
        $_SESSION['error'] = "Username tidak ditemukan.";
        header("Location: login.php");
        exit;
    }

    $user = $result->fetch_assoc();

    // Perilaku ketika password salah
    if (!password_verify($password, $user['password'])) {
        $_SESSION['error'] = "Password salah.";
        header("Location: login.php");
        exit;
    }

    // Perilaku ketika login berhasil
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['success'] = "Login berhasil. Selamat datang!";
    header("Location: dashboard.php");
    exit;

    // Perilaku ketika login gagal — sudah tertangani di atas (username tidak ditemukan atau password salah)
}
?>

<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_POST['email'];

    $checkUsernameStmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
    $checkUsernameStmt->bind_param("s", $username);
    $checkUsernameStmt->execute();
    $checkUsernameStmt->store_result();

    // buat perilaku ketika username sudah ada
    if ($checkUsernameStmt->num_rows > 0) {
        $checkUsernameStmt->close(); 
        header("Location: ../register.php?error=username_exists");
        exit();
    }

    // buat perilaku ketika password tidak sama
    if ($password !== $confirm_password) {
        $checkUsernameStmt->close(); 
        header("Location: ../register.php?error=password_mismatch");
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    // buat perilaku ketika register berhasil
    if ($stmt->execute()) {
        $stmt->close();
        header("Location: ../login.php?register=success");
        exit();

    // buat perilaku ketika register gagal
    } else {
        $stmt->close();
        header("Location: ../register.php?error=register_failed");
        exit();
    }

// Jika method bukan POST
} else {
    header("Location: ../register.php?error=invalid_request");
    exit();
}
?>
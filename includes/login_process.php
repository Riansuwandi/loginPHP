<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT password, email, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($db_pwd, $db_email, $db_role);
        $stmt->fetch();

        // buat perilaku ketika login berhasil
        if (password_verify($password, $db_pwd)) {
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $db_email;
            $_SESSION['role'] = $db_role;
            $stmt->close();
            header("Location: ../dashboard.php"); 
            exit();

        // buat perilaku ketika login gagal
        // buat perilaku ketika salah username atau password
        // buat perilaku ketika password salah
        } else {
            $stmt->close();
            header("Location: ../login.php?error=password");
            exit();
        }
    // buat perilaku ketika login gagal
    // buat perilaku ketika username tidak ditemukan
    } else {
        $stmt->close();
        header("Location: ../login.php?error=username");
        exit();
    }

// buat perilaku ketika login gagal karena salah method
} else {
    header("Location: ../login.php?error=invalid_request");
    exit();
}
?>
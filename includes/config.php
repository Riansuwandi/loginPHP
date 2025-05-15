<?php
$host = 'localhost';
$database = 'rianganteng';
$username = 'root';
$pass = ''; // default for Laragon

// Membuat koneksi
$conn = mysqli_connect($host, $username, $password, $database);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
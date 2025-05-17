<?php
$servername = "localhost";  // Server database (bisa berubah sesuai kebutuhan)
$username = "root";         // Ganti dengan username MySQL kamu
$password = "";             // Ganti dengan password MySQL kamu
$dbname = "horus_reza_db";  // Ganti dengan nama database yang kamu buat

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

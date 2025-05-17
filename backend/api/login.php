<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

include('../db_config.php');  // Mengimpor koneksi ke database

// Mengambil data dari request POST
if (isset($_POST['username'], $_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
} else {
    echo json_encode(['status' => 'error', 'message' => 'Username dan password harus diisi']);
    exit;
}

// Query untuk memeriksa apakah username dan password cocok dengan data di database
$sql = "SELECT * FROM user WHERE username='$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Cek apakah password yang dimasukkan cocok dengan yang ada di database
    if (password_verify($password, $row['password'])) {
        echo json_encode(['status' => 'success', 'message' => 'Login berhasil']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Password salah']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'User tidak ditemukan']);
}

$conn->close();
?>

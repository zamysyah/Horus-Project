<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

include('../db_config.php');  // Mengimpor koneksi ke database

// Mengambil data dari request POST
if (isset($_POST['username'], $_POST['password'], $_POST['email'], $_POST['nama'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Hash password untuk keamanan
    $email = $_POST['email'];
    $nama = $_POST['nama'];
} else {
    echo json_encode(['status' => 'error', 'message' => 'Semua field harus diisi']);
    exit;
}

// Validasi input (contoh pengecekan kosong)
if (empty($username) || empty($password) || empty($email) || empty($nama)) {
    echo json_encode(['status' => 'error', 'message' => 'Semua field harus diisi']);
    exit;
}

// Query untuk memasukkan data user ke database
$sql = "INSERT INTO user (username, password, email, nama) VALUES ('$username', '$password', '$email', '$nama')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['status' => 'success', 'message' => 'User berhasil didaftarkan']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data ke database']);
}

$conn->close();  // Menutup koneksi database
?>

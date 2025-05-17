<?php
header("Access-Control-Allow-Origin: *");  // Mengizinkan permintaan dari semua origin
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");  // Mengizinkan metode HTTP tertentu
header("Access-Control-Allow-Headers: Content-Type");  // Mengizinkan header Content-Type

include('../db_config.php');  // Mengimpor koneksi ke database

// Query untuk mengambil semua user
$sql = "SELECT id, username, email, nama FROM user";
$result = $conn->query($sql);

// Cek apakah ada data
if ($result->num_rows > 0) {
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    echo json_encode($users);  // Mengembalikan data user dalam format JSON
} else {
    echo json_encode(['status' => 'error', 'message' => 'Tidak ada data user']);
}

$conn->close();  // Menutup koneksi database
?>

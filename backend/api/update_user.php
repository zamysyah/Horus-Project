<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

include('../db_config.php');  // Mengimpor koneksi ke database

// Memeriksa apakah permintaan adalah PUT
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $data);  // Mengambil data JSON atau form data dari body

    if (isset($data['username'], $data['password'], $data['email'], $data['nama'])) {
        $username = $data['username'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);  // Hash password
        $email = $data['email'];
        $nama = $data['nama'];

        // Query untuk memperbarui data user berdasarkan ID
        $sql = "UPDATE user SET username='$username', password='$password', email='$email', nama='$nama' WHERE id=" . $_GET['id'];

        if ($conn->query($sql) === TRUE) {
            echo json_encode(['status' => 'success', 'message' => 'User berhasil diperbarui']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui data user']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Semua field harus diisi']);
    }
}

$conn->close();  // Menutup koneksi database
?>

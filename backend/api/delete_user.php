<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

include('../db_config.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    // Ambil data user sebelum dihapus
    $check = $conn->query("SELECT * FROM user WHERE id = $id");
    if ($check->num_rows > 0) {
        $user = $check->fetch_assoc();
        $username = $user['username'];
        $nama = $user['nama'];
        $email = $user['email'];

        // Hapus user
        $sql = "DELETE FROM user WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            // Simpan log
            $log = "[" . date("Y-m-d H:i:s") . "] User Dihapus: $nama ($username, $email)\n";
            file_put_contents("delete_log.txt", $log, FILE_APPEND);

            echo json_encode(['status' => 'success', 'message' => 'User berhasil dihapus']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus user']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User tidak ditemukan']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID tidak valid']);
}

$conn->close();
?>

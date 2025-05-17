<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}
// rest of your PHP code


include('../db_config.php');  // Mengimpor koneksi ke database

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    $id = intval($data->id);

    $sql = "DELETE FROM products WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Product deleted successfully."]);
    } else {
        http_response_code(503);
        echo json_encode(["message" => "Unable to delete product."]);
    }
} else {
    http_response_code(400);
    echo json_encode(["message" => "Product ID is required."]);
}
?>

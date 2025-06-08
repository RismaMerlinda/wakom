<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

include "../database/koneksi.php";

// Ambil data dari body JSON
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["success" => false, "message" => "No input data received"]);
    exit;
}

// Ambil nilai dari JSON body
$id_user = isset($data['id_user']) ? $data['id_user'] : null;
$tanggal = isset($data['tanggal']) ? $data['tanggal'] : date('Y-m-d H:i:s');
$total   = isset($data['total']) ? $data['total'] : 0;

// Validasi sederhana
if (!$id_user || !$total) {
    echo json_encode(["success" => false, "message" => "Missing required fields"]);
    exit;
}

// Insert ke database
$query = "INSERT INTO tb_transaksi (id_user, tanggal, total) VALUES (?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("isd", $id_user, $tanggal, $total);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Transaksi berhasil ditambahkan",
        "id_transaksi" => $stmt->insert_id
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Gagal menambahkan transaksi", "error" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>

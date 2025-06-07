<?php
header('Content-Type: application/json');
include "database/koneksi.php";
session_start();

// Cek autentikasi
if (!isset($_SESSION['id_user'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}

$id_user = $_SESSION['id_user'];

// Pastikan metode adalah POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit;
}

// Ambil dan decode data JSON
$data = json_decode(file_get_contents("php://input"), true);

// Validasi data wajib
if (
    !isset($data['id_order']) ||
    !isset($data['total_harga']) ||
    !isset($data['metode_pembayaran']) ||
    empty(trim($data['id_order']))
) {
    echo json_encode(["status" => "error", "message" => "Data transaksi tidak lengkap"]);
    exit;
}

$id_order           = mysqli_real_escape_string($conn, $data['id_order']);
$total_harga       = floatval($data['total_harga']);
$metode_pembayaran = mysqli_real_escape_string($conn, $data['metode_pembayaran']);
$tanggal_transaksi = date('Y-m-d H:i:s');

// Simpan transaksi ke dalam database
$query = "INSERT INTO tb_transaksi (id_order, id_user, total_harga, metode_pembayaran, tanggal_transaksi)
          VALUES ('$id_order', '$id_user', '$total_harga', '$metode_pembayaran', '$tanggal_transaksi')";

if (mysqli_query($conn, $query)) {
    echo json_encode(["status" => "success", "message" => "Transaksi berhasil disimpan"]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Gagal menyimpan transaksi",
        "error" => mysqli_error($conn)
    ]);
}
?>

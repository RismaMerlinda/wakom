<?php
header('Content-Type: application/json');
include "database/koneksi.php";
session_start();

// Pastikan pengguna login
if (!isset($_SESSION['id_user'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized. Please login first."]);
    exit;
}

$id_user = $_SESSION['id_user'];

// Validasi method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit;
}

// Ambil data dari body POST
$data = json_decode(file_get_contents("php://input"), true);

// Validasi data
if (
    !isset($data['no_meja']) ||
    !isset($data['uang_bayar']) ||
    !isset($data['pesanan']) || !is_array($data['pesanan'])
) {
    echo json_encode(["status" => "error", "message" => "Incomplete or invalid data"]);
    exit;
}

$no_meja = intval($data['no_meja']);
$uang_bayar = intval($data['uang_bayar']);
$waktu_pesan = date('Y-m-d H:i:s');
$total_harga = 0;

// Hitung total harga dari pesanan
foreach ($data['pesanan'] as $item) {
    if (!isset($item['id_masakan']) || !isset($item['jumlah'])) {
        echo json_encode(["status" => "error", "message" => "Item pesanan tidak lengkap"]);
        exit;
    }

    $id_masakan = intval($item['id_masakan']);
    $jumlah = intval($item['jumlah']);

    $qHarga = mysqli_query($conn, "SELECT harga FROM tb_masakan WHERE id_masakan = $id_masakan");
    $rowHarga = mysqli_fetch_assoc($qHarga);

    if (!$rowHarga) {
        echo json_encode(["status" => "error", "message" => "ID masakan $id_masakan tidak ditemukan"]);
        exit;
    }

    $total_harga += $rowHarga['harga'] * $jumlah;
}

$uang_kembali = $uang_bayar - $total_harga;

// Simpan ke tb_order
$query_order = "INSERT INTO tb_order (id_pengunjung, waktu_pesan, no_meja, total_harga, uang_bayar, uang_kembali) 
                VALUES ($id_user, '$waktu_pesan', $no_meja, $total_harga, $uang_bayar, $uang_kembali)";
$result_order = mysqli_query($conn, $query_order);

if (!$result_order) {
    echo json_encode(["status" => "error", "message" => "Gagal menyimpan order"]);
    exit;
}

$id_order = mysqli_insert_id($conn);

// Simpan ke tb_pesan
foreach ($data['pesanan'] as $item) {
    $id_masakan = intval($item['id_masakan']);
    $jumlah = intval($item['jumlah']);

    $query_pesan = "INSERT INTO tb_pesan (id_order, id_masakan, jumlah) 
                    VALUES ($id_order, $id_masakan, $jumlah)";
    mysqli_query($conn, $query_pesan);
}

echo json_encode([
    "status" => "success",
    "message" => "Order berhasil disimpan",
    "data" => [
        "id_order" => $id_order,
        "total_harga" => $total_harga,
        "uang_kembali" => $uang_kembali
    ]
]);
?>

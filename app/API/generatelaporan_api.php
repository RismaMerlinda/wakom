<?php
header('Content-Type: application/json');
include "database/koneksi.php";
session_start();

// Cek autentikasi
if (!isset($_SESSION['id_user'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}

// Tangkap parameter filter tanggal jika ada
$tanggal_mulai = isset($_GET['tanggal_mulai']) ? $_GET['tanggal_mulai'] : null;
$tanggal_selesai = isset($_GET['tanggal_selesai']) ? $_GET['tanggal_selesai'] : null;

// Validasi tanggal (jika ada)
$where = "";
if ($tanggal_mulai && $tanggal_selesai) {
    $tanggal_mulai = mysqli_real_escape_string($conn, $tanggal_mulai);
    $tanggal_selesai = mysqli_real_escape_string($conn, $tanggal_selesai);
    $where = "WHERE tanggal_transaksi BETWEEN '$tanggal_mulai 00:00:00' AND '$tanggal_selesai 23:59:59'";
}

// Query laporan transaksi
$query = "SELECT 
            tb_transaksi.id_transaksi,
            tb_transaksi.id_order,
            tb_user.nama_user,
            tb_transaksi.total_harga,
            tb_transaksi.metode_pembayaran,
            tb_transaksi.tanggal_transaksi
          FROM tb_transaksi
          JOIN tb_user ON tb_transaksi.id_user = tb_user.id_user
          $where
          ORDER BY tb_transaksi.tanggal_transaksi DESC";

$result = mysqli_query($conn, $query);

$laporan = [];
while ($row = mysqli_fetch_assoc($result)) {
    $laporan[] = $row;
}

echo json_encode([
    "status" => "success",
    "jumlah_data" => count($laporan),
    "data" => $laporan
]);
?>

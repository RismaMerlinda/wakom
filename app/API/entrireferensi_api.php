<?php
header('Content-Type: application/json');
include "database/koneksi.php";
session_start();

// Cek login
if (!isset($_SESSION['id_user'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized access"]);
    exit;
}

$id_user = $_SESSION['id_user'];

// Validasi method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit;
}

// Ambil data JSON dari body request
$data = json_decode(file_get_contents("php://input"), true);

// Validasi input
if (
    !isset($data['nama_referensi']) ||
    !isset($data['deskripsi']) ||
    empty(trim($data['nama_referensi']))
) {
    echo json_encode(["status" => "error", "message" => "Nama referensi wajib diisi"]);
    exit;
}

$nama_referensi = mysqli_real_escape_string($conn, $data['nama_referensi']);
$deskripsi = mysqli_real_escape_string($conn, $data['deskripsi']);
$tanggal_input = date('Y-m-d H:i:s');

// Simpan ke database, sesuaikan dengan nama tabel dan kolom
$query = "INSERT INTO tb_referensi (id_user, nama_referensi, deskripsi, tanggal_input)
          VALUES ('$id_user', '$nama_referensi', '$deskripsi', '$tanggal_input')";

if (mysqli_query($conn, $query)) {
    echo json_encode(["status" => "success", "message" => "Referensi berhasil disimpan"]);
} else {
    echo json_encode(["status" => "error", "message" => "Gagal menyimpan referensi", "error" => mysqli_error($conn)]);
}
?>

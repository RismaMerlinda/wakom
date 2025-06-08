<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include "database/koneksi.php";

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_masakan = $_POST['nama_masakan'] ?? '';
    $harga = $_POST['harga'] ?? '';
    $stok = $_POST['stok'] ?? '';
    $status_masakan = ($stok > 0) ? 'tersedia' : 'habis';
    $gambar = "no_image.png";

    // Cek dan simpan gambar jika ada
    if (isset($_FILES['gambar']['tmp_name']) && $_FILES['gambar']['tmp_name'] != "") {
        $direktori = "gambar/";
        $ext = pathinfo($_FILES["gambar"]["name"], PATHINFO_EXTENSION);
        $nama_baru = $nama_masakan . "." . $ext;
        $upload_path = $direktori . $nama_baru;

        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $upload_path)) {
            $gambar = $nama_baru;
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Gagal upload gambar."]);
            exit;
        }
    }

    // Query insert
    $query = "INSERT INTO tb_masakan (id_masakan, nama_masakan, harga, stok, status_masakan, gambar_masakan)
              VALUES (NULL, '$nama_masakan', '$harga', '$stok', '$status_masakan', '$gambar')";

    if (mysqli_query($conn, $query)) {
        http_response_code(201);
        $response = [
            "status" => "success",
            "message" => "Menu berhasil ditambahkan",
            "data" => [
                "nama_masakan" => $nama_masakan,
                "harga" => $harga,
                "stok" => $stok,
                "status_masakan" => $status_masakan,
                "gambar" => $gambar
            ]
        ];
    } else {
        http_response_code(500);
        $response = [
            "status" => "error",
            "message" => "Gagal menyimpan ke database",
            "error" => mysqli_error($conn)
        ];
    }
} else {
    http_response_code(405);
    $response = [
        "status" => "error",
        "message" => "Metode tidak diizinkan"
    ];
}

echo json_encode($response);
?>

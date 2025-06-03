<?php
header('Content-Type: application/json');
include "database/koneksi.php";

if (!isset($_GET['id_order'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Parameter id_order tidak ditemukan"
    ]);
    exit();
}

$id_order = intval($_GET['id_order']);

// Ambil data order
$query_order = "SELECT * FROM tb_order 
                LEFT JOIN tb_user ON tb_order.id_pengunjung = tb_user.id_user 
                WHERE id_order = $id_order";
$sql_order = mysqli_query($conn, $query_order);
$result_order = mysqli_fetch_assoc($sql_order);

if (!$result_order) {
    echo json_encode([
        "status" => "error",
        "message" => "Data order tidak ditemukan"
    ]);
    exit();
}

// Ambil data detail menu
$query_items = "SELECT * FROM tb_pesan 
                NATURAL JOIN tb_masakan 
                WHERE id_order = $id_order";
$sql_items = mysqli_query($conn, $query_items);

$items = [];
while ($item = mysqli_fetch_assoc($sql_items)) {
    $total = $item['harga'] * $item['jumlah'];
    $items[] = [
        "nama_masakan" => $item['nama_masakan'],
        "jumlah" => intval($item['jumlah']),
        "harga" => intval($item['harga']),
        "total" => $total
    ];
}

// Gabungkan data
$response = [
    "status" => "success",
    "data" => [
        "id_order" => $result_order['id_order'],
        "nama_pelanggan" => $result_order['nama_user'],
        "waktu_pesan" => $result_order['waktu_pesan'],
        "no_meja" => $result_order['no_meja'],
        "total_harga" => intval($result_order['total_harga']),
        "uang_bayar" => intval($result_order['uang_bayar']),
        "uang_kembali" => intval($result_order['uang_kembali']),
        "items" => $items
    ]
];

// Keluarkan data
echo json_encode($response, JSON_PRETTY_PRINT);
?>

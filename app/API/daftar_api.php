<?php
require_once '../database/koneksi.php';

class RegisterController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register() {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(["message" => "Method not allowed"]);
            exit;
        }

        $input = json_decode(file_get_contents("php://input"), true);

        // Validasi input
        if (
            empty($input['nama_user']) ||
            empty($input['username']) ||
            empty($input['password']) ||
            empty($input['id_level'])
        ) {
            http_response_code(400);
            echo json_encode(["message" => "Semua data wajib diisi"]);
            return;
        }

        $nama_user = mysqli_real_escape_string($this->conn, $input['nama_user']);
        $username  = mysqli_real_escape_string($this->conn, $input['username']);
        $password  = mysqli_real_escape_string($this->conn, $input['password']);
        $id_level  = mysqli_real_escape_string($this->conn, $input['id_level']);
        $status    = 'nonaktif';

        // Cek apakah username sudah ada
        $cek = mysqli_query($this->conn, "SELECT id_user FROM tb_user WHERE username = '$username'");
        if (mysqli_num_rows($cek) > 0) {
            http_response_code(409); // Conflict
            echo json_encode(["message" => "Username sudah digunakan"]);
            return;
        }

        // Proses insert ke database
        $query = "INSERT INTO tb_user (id_user, username, password, nama_user, id_level, status)
                  VALUES ('', '$username', '$password', '$nama_user', '$id_level', '$status')";
        
        if (mysqli_query($this->conn, $query)) {
            echo json_encode(["message" => "Pendaftaran berhasil, menunggu aktivasi admin"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Terjadi kesalahan saat menyimpan data"]);
        }
    }
}

$controller = new RegisterController($conn);
$controller->register();

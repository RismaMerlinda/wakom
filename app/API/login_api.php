<?php
require_once '../database/koneksi.php';
session_start();

class LoginController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login() {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(["message" => "Method not allowed"]);
            exit;
        }

        $input = json_decode(file_get_contents("php://input"), true);
        $username = mysqli_real_escape_string($this->conn, $input['username']);
        $password = mysqli_real_escape_string($this->conn, $input['password']);

        $query = "SELECT * FROM tb_user WHERE username='$username' AND password='$password' AND status='aktif' LIMIT 1";
        $result = mysqli_query($this->conn, $query);

        if (mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);
            $_SESSION['username'] = $user['username'];
            $_SESSION['id_user'] = $user['id_user'];
            echo json_encode(["message" => "Login sukses", "user" => $user]);
        } else {
            http_response_code(401);
            echo json_encode(["message" => "Login gagal"]);
        }
    }
}

$controller = new LoginController($conn);
$controller->login();

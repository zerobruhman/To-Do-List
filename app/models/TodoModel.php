<?php
require_once __DIR__ . "/../../core/Database.php";

class TodoModel {
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->conn;
    }
    public function getAll($user_id) {
        $query = "SELECT * FROM Todos WHERE user_id = ?";
        $pernyataan = $this->db->prepare($query);
        $pernyataan->bind_param(
            "i",
            $user_id
        );
        $pernyataan->execute();
        $hasil = $pernyataan->get_result();
        $data = [];
        while ($row = $hasil->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    public function createTodo(int $user_id, string $judul, string $deskripsi = '') {
        $query = "INSERT INTO Todos (user_id, judul, deskripsi) VALUES (
        ?, ?, ?
        )";
        $pernyataan = $this->db->prepare($query);
        $pernyataan->bind_param(
            "iss",
            $user_id,
            $judul,
            $deskripsi
        );
        return $pernyataan->execute();
    }
}
?>
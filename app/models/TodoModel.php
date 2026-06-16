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
    public function findById(int $id) {
        $query = "SELECT * FROM Todos WHERE id = ?";
        $pernyataan = $this->db->prepare($query);
        $pernyataan->bind_param("i", $id);
        $pernyataan->execute();
        return $pernyataan->get_result()->fetch_assoc();
    }
    public function updateStatus(int $id, string $status) {
        $query = "UPDATE Todos SET status = ? WHERE id = ?";
        $pernyataan = $this->db->prepare($query);
        $pernyataan->bind_param("si", $status, $id);
        return $pernyataan->execute();
    }
}
?>
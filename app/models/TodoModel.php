<?php
require_once __DIR__ . "/../../core/Database.php";

class TodoModel {
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->conn;
    }
    public function getAll(int $user_id, int $limit, int $offset) {
        $query = "SELECT * FROM Todos WHERE user_id = ? LIMIT ? OFFSET ?";
        $pernyataan = $this->db->prepare($query);
        $pernyataan->bind_param(
            "iii",
            $user_id,
            $limit,
            $offset
        );
        $pernyataan->execute();
        $hasil = $pernyataan->get_result();
        $data = [];
        while ($row = $hasil->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    public function countAll($user_id) {
        $query = "SELECT COUNT(*) as total FROM Todos WHERE user_id = ?";
        $pernyataan = $this->db->prepare($query);
        $pernyataan->bind_param("i", $user_id);
        $pernyataan->execute();
        $hasil = $pernyataan->get_result();
        $baris = $hasil->fetch_assoc();
        return (int) $baris['total'];
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
    public function update(array $todo_data) {
        $query = "UPDATE Todos SET judul = ?, deskripsi = ? WHERE id = ? AND user_id = ?";
        $pernyataan = $this->db->prepare($query);
        $pernyataan->bind_param("ssii", $todo_data['judul'], $todo_data['deskripsi'], $todo_data['id'], $todo_data['user_id']);
        return $pernyataan->execute();
    }
    public function updateStatus(int $id, string $status) {
        $query = "UPDATE Todos SET status = ? WHERE id = ?";
        $pernyataan = $this->db->prepare($query);
        $pernyataan->bind_param("si", $status, $id);
        return $pernyataan->execute();
    }
    public function delete(int $id, int $user_id) {
        $query = "DELETE FROM Todos WHERE id = ? AND user_id = ?";
        $pernyataan = $this->db->prepare($query);
        $pernyataan->bind_param("ii", $id, $user_id);
        return $pernyataan->execute();
    }
}
?>
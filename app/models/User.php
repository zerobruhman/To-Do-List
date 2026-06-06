<?php
require_once __DIR__ . "/../../core/Database.php";

class User {
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->koneksi;        
    }
    public function register($username, $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $perintah_query = "INSERT INTO Users(username, password) VALUES (?, ?)";
        $pernyataan = $this->db->prepare($perintah_query);
        $pernyataan->bind_param(
            "ss",
            $username,
            $hash
        );
        return $pernyataan->execute();
    }
    public function cariUser($username) {
        $perintah_query = "SELECT * FROM Users WHERE username = ?";
        $pernyataan = $this->db->prepare($perintah_query);
        $pernyataan->bind_param(
            "s",
            $username
        );
        $pernyataan->execute();
        $hasil = $pernyataan->get_result();
        return $hasil->fetch_assoc();
    }
    public function tampilkansemuaUser() {
        $perintah_query = "SELECT * FROM Users";
        $hasil = $this->db->query($perintah_query);
        $data = [];
        while ($row = $hasil->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    public function hapusUser($id) {
        $perintah_query = "DELETE FROM Users WHERE id = ?";
        $pernyataan = $this->db->prepare($perintah_query);
        $pernyataan->bind_param(
            "i",
            $id
        );
        return $pernyataan->execute();
    }
    public function updateUser($username, $id) {
        $perintah_query = "UPDATE Users SET username = ? WHERE id = ?";
        $pernyataan = $this->db->prepare($perintah_query);
        $pernyataan->bind_param(
            "si",
            $username,
            $id
        );
        return $pernyataan->execute();
    }
    public function updatePassword($password, $id) {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $perintah_query = "UPDATE Users SET password = ? WHERE id = ?";
        $pernyataan = $this->db->prepare($perintah_query);
        $pernyataan->bind_param(
            "si",
            $hash,
            $id
        );
        return $pernyataan->execute();
    }
    public function ambilUserberdasarkanid($id) {
        $perintah_query = "SELECT * FROM Users WHERE id = ?";
        $pernyataan = $this->db->prepare($perintah_query);
        $pernyataan->bind_param(
            "i",
            $id
        );
        $pernyataan->execute();
        $hasil = $pernyataan->get_result();
        return $hasil->fetch_assoc();
    }
}
?>
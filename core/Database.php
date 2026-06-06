<?php
require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

class Database {
    private $host;
    private $username;
    private $password;
    private $db_name;

    public $conn;

    public function __construct()
    {
        $this->host = $_ENV['DB_HOST'];
        $this->username = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASS'];
        $this->db_name = $_ENV['DB_NAME'];

        $this->conn = mysqli_connect(
            $this->host,
            $this->username,
            $this->password,
            $this->db_name
        );

        if (!$this->conn) 
            die("Koneksi gagal!");
    }
}
?>
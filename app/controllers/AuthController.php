<?php
require_once __DIR__ . "/../models/User.php";

class AuthController {
    private $modeluser;

    public function __construct()
    {
        $this->modeluser = new User();
    }
    public function register() {
        $error = null;
        if (isset($_POST['register'])) {
            CSRF::verifyCsrfToken();
            $username = trim($_POST['username'] ?? "");
            $password = trim($_POST['password'] ?? "");

            $error = $this->validate_register($username, $password);
            if (empty($error)) {
                $this->modeluser->register($username, $password);
                header("Location: /public/index.php?action=login");
                exit;
            }
        }
        require __DIR__ . "/../views/auth/register.php";
    }
    public function login() {
        $error = null;
        if (isset($_POST['login'])) {
            CSRF::verifyCsrfToken();
            $username = trim($_POST['username'] ?? "");
            $password = trim($_POST['password'] ?? "");

            $error = $this->validate_login($username, $password);
        }
        require __DIR__ . "/../views/auth/login.php";
    }
    public function logout() {
        session_destroy();

        header("Location: /public/index.php?action=login");
        exit(0);
    }
    private function validate_register($username, $password) {
        if (empty($username))
            return "Usename tolong di isi!";
        if (empty($password))
            return "Password tolong di isi!";
        if (strlen($password) < 8)
            return "Password minimal 8 karakter!";
    }
    private function validate_login($username, $password) {
        if (empty($username))
            return "Username tolong di isi";
        if (empty($password))
            return "Password tolong di isi";
        $user = $this->modeluser->cariUser($username);
        if (!$user) {
            return "User tidak terdaftar";
        }
        if (password_verify($password, $user['password'])) { 
            $_SESSION['login'] = true;
            $_SESSION['username'] = $user["username"];
            $_SESSION['role'] = $user['role'];

            header("Location: /public/index.php?action=todo");
            exit();
        }
        return "Login gagal! Username atau Password salah!";
    } 
}
?>
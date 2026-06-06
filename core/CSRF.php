<?php
class CSRF {
    public static function GenerateCsrftoken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    public static function verifyCsrfToken() {
        $token = $_POST['csrf_token'] ?? '';
        $sessionToken = $_SESSION['csrf_token'] ?? '';
        if (!hash_equals($sessionToken, $token)) {
            http_response_code(403);
            die("CSRF token tidak valid");
        }  
    }
    public static function verifyMethodPost() {
        if ($_SERVER['REQUEST_METHOD'] !== "POST") {
            http_response_code(405);
            die("Method tidak di izinkan");
        }
    }
}
?>
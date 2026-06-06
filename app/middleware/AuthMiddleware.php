<?php
class AuthMiddleware {
    public static function check() {
        if(!isset($_SESSION['login'])) {
            header("Location: /public/index.php?action=login");
            exit;
        }
    }
}
?>
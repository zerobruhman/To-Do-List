<?php
class AdminMiddleware {
    public static function check() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin')
            die("AKSES DITOLAK!");
    }
}
?>
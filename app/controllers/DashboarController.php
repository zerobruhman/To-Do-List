<?php
require_once __DIR__ . "/../middleware/AuthMiddleware.php";
require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../middleware/AdminMiddleware.php";
class DashboarController {

    private $usermodel;

    public function __construct()
    {
        $this->usermodel = new User();
    }
    public function index() {
        AuthMiddleware::check();
        AdminMiddleware::check();        

        $users = $this->usermodel->tampilkansemuaUser();
        require __DIR__ . "/../views/dashboard.php";
    }
    public function hapusUser($id) {
        AuthMiddleware::check();
        AdminMiddleware::check();
        CSRF::verifyCsrfToken();

        $this->usermodel->hapusUser($id);
        header("Location: index.php?action=dashboard");
        exit;
    }
    public function updateUser($id) {
        AuthMiddleware::check();
        AdminMiddleware::check();
        
        $user = $this->usermodel->ambilUserberdasarkanid($id);
        $errors = null;
        if (isset($_POST['update'])) {
            $data = [
                'username' => $_POST['username'] ?? '',
                'new_password' => $_POST['new_password'] ?? '',
                'old_password' => $_POST['old_password'] ?? '',
                'verify_password' => $_POST['verify_password'] ?? ''
            ];
            $errors = $this->validate_update($data, $user['password']);

            if (empty($errors)) {
                $this->usermodel->updateUser($data['username'], $id);

                if (!empty($data['new_password']))
                    $this->usermodel->updatePassword($data['new_password'], $id);

                header("Location: /public/index.php?action=dashboard");
                exit;   
            }
        }
        require __DIR__ . "/../views/edit.php";
    }
        private function validate_update(array $data, $password) {
            $errors = [];
            $data = array_map('trim', $data);
            $PasswordmaudiGanti = !empty($data['new_password']) || !empty($data['old_password']) || !empty($data['verify_password']);
            if (empty($data['username']))
                $errors[] = "Username tidak boleh kosong!";
            if ($PasswordmaudiGanti) {
                // Validasi input kosong
                if (empty($data['old_password'])) 
                    $errors[] = "Old Password tolong di isi!";
                if (empty($data['new_password']))
                    $errors[] = "New Password tolong di isi!";
                if (empty($data['verify_password'])) 
                    $errors[] = "Verify Password tolong di isi!";
                if (empty($errors)) {
                    // Validasi Old Password User
                    if (!password_verify($data['old_password'], $password))
                        $errors[] = "Old Password salah!";
                    // Validasi New Password == Verify Password
                    if ($data['new_password'] !== $data['verify_password'])
                        $errors[] = "Password tidak cocok!";
                    // Validasi minimal character Password
                    if (strlen($data['new_password']) < 8)
                        $errors[] = "Password minimal 8 karakter!";
                }
            }
            return $errors;
        }
}
?>
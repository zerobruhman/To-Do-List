<?php
require_once __DIR__ . "/../models/TodoModel.php";
require_once __DIR__ . "/../middleware/AuthMiddleware.php";

class TodoController {
    private $todomodel;

    public function __construct()
    {
        $this->todomodel = new TodoModel();
    }
    public function index() {
        AuthMiddleware::check();
        
        $todos = $this->todomodel->getAll($_SESSION['user_id']);

        require __DIR__ . "/../views/todo/index.php";
    }
    public function store() {
        $judul = $_POST['judul'] ?? '';
        $deskripsi = $_POST['deskripsi'] ?? '';
        $user_id = $_SESSION['user_id'];

        $this->todomodel->createTodo($user_id, $judul, $deskripsi);
        header("Location: index.php?action=todo");
        exit();
    }
    public function toggleStatus() {
        $todo_id = $_POST['todo_id'] ?? '';
        $user_id = $_SESSION['user_id'];
        $todos = $this->todomodel->findById($todo_id);

        $statusbaru = ($todos['status'] == 'pending') ? 'selesai' : 'pending';
        $this->todomodel->updateStatus($todo_id, $statusbaru);
        header("Location: index.php?action=todo");
        exit;
    }
    public function deleteTodo() {
        $todo_id = $_POST['todo_id'] ?? '';
        $user_id = $_SESSION['user_id'] ?? '';
        
        $this->todomodel->delete($todo_id, $user_id);
        header("Location: index.php?action=todo");
        exit;
    }
}
?>
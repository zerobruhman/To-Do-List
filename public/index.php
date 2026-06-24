    <?php
    session_start();

    require_once __DIR__ . "/../app/controllers/AuthController.php";
    require_once __DIR__ . "/../app/controllers/DashboarController.php";
    require_once __DIR__ . "/../app/controllers/TodoController.php";
    require_once __DIR__ . "/../core/CSRF.php";

    $auth = new AuthController();
    $dashboard = new DashboarController();
    $todo = new TodoController();
    $action = $_GET['action'] ?? "login";

    switch ($action) {
        case "login":
            $auth->login();
            break;
        case "register":
            $auth->register();
            break;
        case "dashboard":
            $dashboard->index();
            break;
        case "logout":
            $auth->logout();
            break;
        case "edit":
            CSRF::verifyMethodPost();
            CSRF::verifyCsrfToken();
            
            $id = $_POST['id'] ?? null;
            $dashboard->updateUser($id);
            break;  
        case "delete":
            CSRF::verifyMethodPost();
            CSRF::verifyCsrfToken();
            $id = $_POST['id'] ?? null;
            $dashboard->hapusUser($id);
            break;
        case "todo":
            $todo->index();
            break;
        case "todo-store":
            CSRF::verifyMethodPost();
            CSRF::verifyCsrfToken();
            
            $todo->store();
            break;
        case "todo-toggle":
            CSRF::verifyMethodPost();
            CSRF::verifyCsrfToken();
            
            $todo->toggleStatus();
            break;
        case "todo-delete":
            CSRF::verifyMethodPost();
            CSRF::verifyCsrfToken();

            $todo->deleteTodo();
            break;
        case "todo-edit":
            $todo->updateTodo();
            break;
        default:
            $auth->login();
            break;
    }
    ?>
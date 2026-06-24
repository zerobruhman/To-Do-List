<?php
require_once __DIR__ . "/../../../core/CSRF.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=Syne:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="/app/views/css/todo-style.css" rel="stylesheet">
</head>
<body>

<nav class="topbar">
    <div class="topbar-brand">
        <span class="brand-dot"></span>
        To Do List
    </div>
    <div class="topbar-right">
        <div class="user-chip">
            <div class="user-avatar">
                <?= strtoupper(substr($_SESSION['username'] ?? 'U', 0, 1)) ?>
            </div>
            <?= htmlspecialchars($_SESSION['username'] ?? '') ?>
            <?php if(($_SESSION['role'] ?? '') === 'admin'): ?>
                &nbsp;<span style="font-size:10px;color:var(--accent);font-family:var(--mono)">[admin]</span>
            <?php endif; ?>
        </div>
        <a href="index.php?action=logout" class="btn-logout">Logout</a>
    </div>
</nav>

<main class="main">

    <div class="page-header">
        <div class="page-title">My Tasks</div>
        <div class="page-sub">// kelola semua tugas kamu di sini</div>
    </div>

    <!-- Add Todo -->
    <div class="add-card">
        <div class="card-header">
            <span class="card-title">+- Edit Todo</span>
        </div>
        <div class="card-body">
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= CSRF::GenerateCsrftoken() ?>">
                <input type="hidden" name="todo_id" value="<?= $todo['id'] ?? '' ?>">
                <div class="form-row">
                    <div class="form-group full">
                        <label class="form-label">Judul</label>
                        <input type="text" name="judul" class="form-input" value="<?= htmlspecialchars($todo['judul'] ?? '') ?>" required>
                    </div>
                    <div class="form-group full">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-textarea"><?= nl2br($todo['deskripsi'] ?? '') ?></textarea>
                    </div>
                </div>
                <div class="todo-action">
                    <button type="submit" class="btn-toggle" name="edit-task">Edit Task</button>
                    <a class="btn-delete" href="index.php?action=todo">Batal</a>
                </div>
            </form>
        </div>
    </div>
</main>
</body>
</html>
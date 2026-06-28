<?php
require_once __DIR__ . "/../../../core/CSRF.php";
$todos = $todos ?? [];
$error = $error ?? null;
$total     = count($todos);
$selesai   = count(array_filter($todos, fn($t) => $t['status'] === 'selesai'));
$pending   = $total - $selesai;
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

    <!-- Stats -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-label">Total Tasks</div>
            <div class="stat-value accent"><?= $total ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Selesai</div>
            <div class="stat-value success"><?= $selesai ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Pending</div>
            <div class="stat-value warn"><?= $pending ?></div>
        </div>
    </div>

    <!-- Add Todo -->
    <div class="add-card">
        <div class="card-header">
            <span class="card-title">+ Tambah Todo Baru</span>
        </div>
        <div class="card-body">
            <?php if ($error): ?>
            <div class="error-box"><?= htmlspecialchars($error) ?></div>
            <?php endif?>
            <form method="POST" action="index.php?action=todo-store">
                <input type="hidden" name="csrf_token" value="<?= CSRF::GenerateCsrftoken() ?>">
                <div class="form-row">
                    <div class="form-group full">
                        <label class="form-label">Judul</label>
                        <input type="text" name="judul" class="form-input"
                               placeholder="Apa yang perlu dilakukan?">
                    </div>
                    <div class="form-group full">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-textarea"
                                  placeholder="Tambahkan catatan atau detail (opsional)…"></textarea>
                    </div>
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn-submit">Buat Task</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Todo List -->
    <div class="list-card">
        <div class="list-header">
            <span class="card-title" style="font-size:12px;font-family:var(--mono);text-transform:uppercase;letter-spacing:.07em;color:var(--text2);">Daftar Todo</span>
            <span class="list-count"><?= $total ?> records</span>
        </div>

        <?php if (empty($todos)): ?>
            <div class="empty-state">// belum ada task — tambahkan satu di atas</div>
        <?php else: ?>
            <?php foreach ($todos as $index => $todo):
                $done = $todo['status'] === 'selesai';
            ?>
            <div class="todo-item <?= $done ? 'done' : '' ?> " style="--i: <?= $index + 1 ?>">
                <div class="todo-check"><?= $done ? '✓' : '○' ?></div>

                <div class="todo-body">
                    <div class="todo-title"><?= htmlspecialchars($todo['judul']) ?></div>
                    <?php if (!empty($todo['deskripsi'])): ?>
                        <div class="todo-desc"><?= nl2br(htmlspecialchars($todo['deskripsi'])) ?></div>
                    <?php endif; ?>
                    <div class="todo-meta">
                        <?php if ($done): ?>
                            <span class="badge badge-done">● selesai</span>
                        <?php else: ?>
                            <span class="badge badge-pending">○ pending</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="todo-actions">
                    <form method="POST" action="index.php?action=todo-toggle" style="display:inline">
                        <input type="hidden" name="csrf_token" value="<?= CSRF::GenerateCsrftoken() ?>">
                        <input type="hidden" name="todo_id" value="<?= $todo['id'] ?>">
                        <button type="submit" class="btn-toggle">
                            <?= $done ? 'Buka' : 'Selesai' ?>
                        </button>
                    </form>
                    <form method="POST" action="index.php?action=todo-delete" style="display:inline">
                        <input type="hidden" name="csrf_token" value="<?= CSRF::GenerateCsrftoken() ?>">
                        <input type="hidden" name="todo_id" value="<?= $todo['id'] ?>">
                        <button type="submit" class="btn-delete"
                            onclick="return confirm('Hapus task ini?')">Hapus
                        </button>
                    </form>
                    <form method="POST" action="index.php?action=todo-edit" style="display: inline;">
                        <input type="hidden" name="csrf_token" value="<?= CSRF::GenerateCsrftoken() ?>">
                        <input type="hidden" name="todo_id" value="<?= $todo['id'] ?>">
                        <button type="submit" class="btn-edit">
                            Edit
                        </button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</main>
</body>
</html>
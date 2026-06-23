<?php
require_once __DIR__ . "/../../../core/CSRF.php";
$todos = $todos ?? [];

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
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg: #0d0f12;
            --surface: #141720;
            --surface2: #1c2030;
            --border: #252a3a;
            --border2: #2e3448;
            --accent: #4f7cff;
            --accent-dim: rgba(79,124,255,0.12);
            --danger: #ff4d4d;
            --danger-dim: rgba(255,77,77,0.1);
            --success: #3ddc97;
            --success-dim: rgba(61,220,151,0.1);
            --warn: #f5a623;
            --warn-dim: rgba(245,166,35,0.1);
            --text: #e8ecf5;
            --text2: #7a8299;
            --text3: #4a5168;
            --mono: 'DM Mono', monospace;
            --sans: 'Syne', sans-serif;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: var(--sans);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Topbar ── */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            height: 56px;
            border-bottom: 1px solid var(--border);
            background: var(--surface);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .topbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.04em;
            color: var(--text);
        }

        .brand-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: var(--accent);
            box-shadow: 0 0 8px var(--accent);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .user-chip {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 5px 12px 5px 5px;
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 999px;
            font-size: 13px;
            color: var(--text2);
        }

        .user-avatar {
            width: 26px; height: 26px;
            border-radius: 50%;
            background: var(--accent-dim);
            border: 1px solid var(--accent);
            display: flex; align-items: center; justify-content: center;
            font-size: 11px;
            font-weight: 600;
            color: var(--accent);
            font-family: var(--mono);
        }

        .btn-logout {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            background: transparent;
            border: 1px solid var(--border2);
            border-radius: 6px;
            color: var(--text2);
            font-family: var(--sans);
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s;
        }

        .btn-logout:hover {
            border-color: var(--danger);
            color: var(--danger);
            background: var(--danger-dim);
        }

        /* ── Main layout ── */
        .main {
            flex: 1;
            padding: 32px;
            max-width: 860px;
            width: 100%;
            margin: 0 auto;
        }

        /* ── Page header ── */
        .page-header { margin-bottom: 28px; }

        .page-title {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: -0.01em;
            color: var(--text);
        }

        .page-sub {
            font-size: 13px;
            color: var(--text3);
            margin-top: 4px;
            font-family: var(--mono);
        }

        /* ── Stats row ── */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 16px 20px;
        }

        .stat-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text3);
            font-family: var(--mono);
            margin-bottom: 8px;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: var(--text);
            font-family: var(--mono);
            line-height: 1;
        }

        .stat-value.accent  { color: var(--accent); }
        .stat-value.success { color: var(--success); }
        .stat-value.warn    { color: var(--warn); }

        /* ── Add-todo card ── */
        .add-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 24px;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 24px;
            border-bottom: 1px solid var(--border);
            background: var(--surface2);
        }

        .card-title {
            font-size: 12px;
            font-weight: 600;
            color: var(--text2);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-family: var(--mono);
        }

        .card-body { padding: 20px 24px; }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }

        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group.full { grid-column: 1 / -1; }

        .form-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text3);
            font-family: var(--mono);
        }

        .form-input,
        .form-textarea {
            background: var(--bg);
            border: 1px solid var(--border2);
            border-radius: 7px;
            padding: 9px 13px;
            color: var(--text);
            font-family: var(--sans);
            font-size: 13px;
            outline: none;
            transition: border-color 0.15s;
            resize: vertical;
        }

        .form-input::placeholder,
        .form-textarea::placeholder { color: var(--text3); }

        .form-input:focus,
        .form-textarea:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(79,124,255,0.1);
        }

        .form-textarea { min-height: 80px; }

        .form-footer {
            display: flex;
            justify-content: flex-end;
        }

        .btn-submit {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 20px;
            background: var(--accent);
            border: none;
            border-radius: 7px;
            color: #fff;
            font-family: var(--sans);
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: opacity 0.15s;
            letter-spacing: 0.02em;
        }

        .btn-submit:hover { opacity: 0.88; }

        /* ── Todo list card ── */
        .list-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }

        .list-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 24px;
            border-bottom: 1px solid var(--border);
        }

        .list-count {
            font-size: 12px;
            font-family: var(--mono);
            color: var(--text3);
            background: var(--surface2);
            padding: 3px 10px;
            border-radius: 999px;
            border: 1px solid var(--border);
        }

        /* ── Todo item ── */
        .todo-item {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            padding: 18px 24px;
            border-bottom: 1px solid var(--border);
            transition: background 0.1s;
            animation: rowIn 0.25s ease both;
        }

        .todo-item:last-child { border-bottom: none; }
        .todo-item:hover { background: var(--surface2); }

        <?php for($i=1;$i<=50;$i++): ?>
        .todo-item:nth-child(<?= $i ?>) { animation-delay: <?= $i * 0.04 ?>s; }
        <?php endfor; ?>

        .todo-check {
            margin-top: 2px;
            flex-shrink: 0;
            font-size: 18px;
            line-height: 1;
        }

        .todo-body { flex: 1; min-width: 0; }

        .todo-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 4px;
            line-height: 1.4;
        }

        .todo-item.done .todo-title {
            color: var(--text3);
            text-decoration: line-through;
        }

        .todo-desc {
            font-size: 12px;
            color: var(--text2);
            font-family: var(--mono);
            white-space: pre-wrap;
            word-break: break-word;
        }

        .todo-meta {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 8px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 9px;
            border-radius: 999px;
            font-size: 10px;
            font-family: var(--mono);
            letter-spacing: 0.06em;
            text-transform: uppercase;
            font-weight: 500;
        }

        .badge-done {
            background: var(--success-dim);
            border: 1px solid rgba(61,220,151,0.25);
            color: var(--success);
        }

        .badge-pending {
            background: var(--warn-dim);
            border: 1px solid rgba(245,166,35,0.2);
            color: var(--warn);
        }

        .todo-actions {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-shrink: 0;
        }

        .btn-toggle {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 5px 12px;
            background: var(--success-dim);
            border: 1px solid rgba(61,220,151,0.2);
            border-radius: 6px;
            color: var(--success);
            font-size: 12px;
            font-family: var(--sans);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s;
        }

        .btn-toggle:hover {
            background: rgba(61,220,151,0.18);
            border-color: var(--success);
        }

        .btn-delete {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 5px 12px;
            background: var(--danger-dim);
            border: 1px solid rgba(255,77,77,0.2);
            border-radius: 6px;
            color: var(--danger);
            font-size: 12px;
            font-family: var(--sans);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s;
        }

        .btn-delete:hover {
            background: rgba(255,77,77,0.18);
            border-color: var(--danger);
        }

        /* ── Empty state ── */
        .empty-state {
            padding: 60px 24px;
            text-align: center;
            color: var(--text3);
            font-size: 13px;
            font-family: var(--mono);
        }

        /* ── Animations ── */
        @keyframes rowIn {
            from { opacity: 0; transform: translateY(6px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
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
            <form method="POST" action="index.php?action=todo-store">
                <input type="hidden" name="csrf_token" value="<?= CSRF::GenerateCsrftoken() ?>">
                <div class="form-row">
                    <div class="form-group full">
                        <label class="form-label">Judul</label>
                        <input type="text" name="judul" class="form-input"
                               placeholder="Apa yang perlu dilakukan?" required>
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
            <?php foreach ($todos as $todo):
                $done = $todo['status'] === 'selesai';
            ?>
            <div class="todo-item <?= $done ? 'done' : '' ?>">
                <div class="todo-check"><?= $done ? '✅' : '⬜' ?></div>

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
                    <!-- Toggle -->
                    <form method="POST" action="index.php?action=todo-toggle" style="display:inline">
                        <input type="hidden" name="csrf_token" value="<?= CSRF::GenerateCsrftoken() ?>">
                        <input type="hidden" name="todo_id" value="<?= $todo['id'] ?>">
                        <button type="submit" class="btn-toggle">
                            <?= $done ? 'Buka' : 'Selesai' ?>
                        </button>
                    </form>
                    <!-- Delete -->
                    <form method="POST" action="index.php?action=todo-delete" style="display:inline">
                        <input type="hidden" name="csrf_token" value="<?= CSRF::GenerateCsrftoken() ?>">
                        <input type="hidden" name="todo_id" value="<?= $todo['id'] ?>">
                        <button type="submit" class="btn-delete"
                                onclick="return confirm('Hapus task ini?')">Hapus</button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</main>
</body>
</html>
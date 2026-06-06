<?php
$users = $users ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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

        /* Top bar */
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

        /* Main layout */
        .main {
            flex: 1;
            padding: 32px;
            max-width: 1100px;
            width: 100%;
            margin: 0 auto;
        }

        /* Page header */
        .page-header {
            margin-bottom: 28px;
        }

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

        /* Stats row */
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

        .stat-value.accent { color: var(--accent); }

        /* Table container */
        .table-wrap {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }

        .table-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 24px;
            border-bottom: 1px solid var(--border);
        }

        .table-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--text2);
            text-transform: uppercase;
            letter-spacing: 0.07em;
            font-family: var(--mono);
        }

        .table-count {
            font-size: 12px;
            font-family: var(--mono);
            color: var(--text3);
            background: var(--surface2);
            padding: 3px 10px;
            border-radius: 999px;
            border: 1px solid var(--border);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            padding: 11px 24px;
            text-align: left;
            font-size: 11px;
            font-family: var(--mono);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text3);
            background: var(--surface2);
            border-bottom: 1px solid var(--border);
            font-weight: 500;
        }

        tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background 0.1s;
        }

        tbody tr:last-child { border-bottom: none; }

        tbody tr:hover { background: var(--surface2); }

        td {
            padding: 14px 24px;
            font-size: 13px;
            vertical-align: middle;
        }

        .td-id {
            font-family: var(--mono);
            color: var(--text3);
            font-size: 12px;
            width: 60px;
        }

        .td-username {
            font-weight: 600;
            color: var(--text);
        }

        .td-password {
            font-family: var(--mono);
            color: var(--text3);
            font-size: 12px;
            letter-spacing: 0.1em;
        }

        .td-actions {
            width: 140px;
            text-align: right;
        }

        .actions-wrap {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 6px;
        }

        .btn-edit {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 5px 12px;
            background: var(--accent-dim);
            border: 1px solid rgba(79,124,255,0.25);
            border-radius: 6px;
            color: var(--accent);
            font-size: 12px;
            font-family: var(--sans);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.15s;
        }

        .btn-edit:hover {
            background: rgba(79,124,255,0.2);
            border-color: var(--accent);
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

        /* Empty state */
        .empty-state {
            padding: 60px 24px;
            text-align: center;
            color: var(--text3);
            font-size: 13px;
            font-family: var(--mono);
        }

        /* Fade-in rows */
        @keyframes rowIn {
            from { opacity: 0; transform: translateY(6px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        tbody tr {
            animation: rowIn 0.25s ease both;
        }

        <?php for($i=1;$i<=20;$i++): ?>
        tbody tr:nth-child(<?= $i ?>) { animation-delay: <?= $i * 0.04 ?>s; }
        <?php endfor; ?>
    </style>
</head>
<body>

<nav class="topbar">
    <div class="topbar-brand">
        <span class="brand-dot"></span>
        AdminPanel
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
        <div class="page-title">User Management</div>
        <div class="page-sub">// semua akun terdaftar</div>
    </div>

    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-label">Total Users</div>
            <div class="stat-value accent"><?= count($users) ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Role Anda</div>
            <div class="stat-value" style="font-size:18px"><?= htmlspecialchars($_SESSION['role'] ?? '-') ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Session</div>
            <div class="stat-value" style="font-size:14px;color:var(--success)">● Aktif</div>
        </div>
    </div>

    <div class="table-wrap">
        <div class="table-header">
            <span class="table-title">Daftar User</span>
            <span class="table-count"><?= count($users) ?> records</span>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th style="text-align:right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($users)): ?>
                <tr>
                    <td colspan="4">
                        <div class="empty-state">// tidak ada user ditemukan</div>
                    </td>
                </tr>
                <?php else: ?>
                <?php foreach($users as $user): ?>
                <tr>
                    <td class="td-id">#<?= $user['id'] ?></td>
                    <td class="td-username"><?= htmlspecialchars($user['username']) ?></td>
                    <td class="td-password">••••••••</td>
                    <td class="td-actions">
                        <div class="actions-wrap">
                            <form method="POST" action="index.php?action=edit" style="display:inline">
                                <input type="hidden" name="csrf_token" value="<?= CSRF::GenerateCsrftoken() ?>">
                                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                <button type="submit" class="btn-edit">Edit</button>
                            </form>                 
                            <form method="POST" action="index.php?action=delete" style="display:inline">
                                <input type="hidden" name="csrf_token" value="<?= CSRF::GenerateCsrftoken() ?>">
                                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                <button type="submit" class="btn-delete"
                                    onclick="return confirm('Hapus user ini?')">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

</body>
</html>
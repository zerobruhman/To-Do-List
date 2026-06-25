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
    <link href="/app/views/css/dashboard-style.css" rel="stylesheet">
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
                <?php foreach($users as $index => $user): ?>
                <tr style="--i: <?= $index + 1 ?>">
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
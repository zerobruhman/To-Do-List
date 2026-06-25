<?php
$user  = $user ?? [];
$errors = $errors ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=Syne:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="/app/views/css/edituser-style.css">
</head>
<body>
<div class="card">
    <div class="brand">
        <span class="brand-dot"></span>
        AdminPanel
        <a href="index.php?action=dashboard" class="back-link">← Dashboard</a>
    </div>

    <h1>Edit User</h1>
    <div class="subtitle">// id: <?= htmlspecialchars($user['id'] ?? '-') ?></div>

    <?php if (!empty($errors)): ?>
        <?php foreach ($errors as $e): ?>
            <div class="error-box"><?= htmlspecialchars($e) ?></div> 
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (empty($user)): ?>
    <div class="error-box">// user tidak ditemukan</div>
    <?php else: ?>
    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?= CSRF::GenerateCsrftoken() ?>">
        <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">

        <div class="field">
            <label>Username</label>
            <input
                type="text"
                name="username"
                value="<?= htmlspecialchars($user['username'] ?? '') ?>"
                placeholder="masukkan username baru"
                autofocus
            >
        </div>

        <div class="field">
            <label>Old Password<span style="color:var(--text3)">(kosongkan jika tidak diganti)</span></label>
            <input
                type="password"
                name="old_password"
                placeholder="••••••••"
            >
        </div>

        <div class="field">
            <label>New Password <span style="color:var(--text3)"></span></label>
            <input
                type="password"
                name="new_password"
                placeholder="••••••••"
            >
        </div>

        <div class="field">
            <label>Verify Password <span style="color:var(--text3)"></span></label>
            <input
                type="password"
                name="verify_password"
                placeholder="••••••••"
            >
        </div>


        <div class="btn-row">
            <a href="index.php?action=dashboard" class="btn-secondary">Batal</a>
            <button type="submit" name="update" class="btn-primary">Simpan</button>
        </div>
    </form>
    <?php endif; ?>
</div>
</body>
</html>
<?php
$error = $error ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=Syne:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="/app/views/css/auth-style.css" rel="stylesheet">
</head>
<body>
<div class="card">
    <div class="brand">
        <span class="brand-dot"></span>
        AdminPanel
    </div>

    <h1>Daftar</h1>
    <div class="subtitle">// buat akun baru</div>

    <?php if($error): ?>
    <div class="error-box"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?= CSRF::GenerateCsrftoken() ?>">

        <div class="field">
            <label>Username</label>
            <input type="text" name="username" placeholder="pilih username" autofocus>
        </div>

        <div class="field">
            <label>Password</label>
            <input type="password" name="password" placeholder="••••••••">
            <div class="hint">// minimal 8 karakter</div>
        </div>

        <button type="submit" name="register" class="btn-primary">Daftar Sekarang</button>
    </form>

    <div class="footer-link">
        Sudah punya akun? <a href="index.php?action=login">Masuk</a>
    </div>
</div>
</body>
</html>
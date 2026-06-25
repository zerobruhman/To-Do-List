<?php
$error = $error ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=Syne:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="/app/views/css/auth-style.css" rel="stylesheet">
</head>
<body>
<div class="card">
    <div class="brand">
        <span class="brand-dot"></span>
        AdminPanel
    </div>

    <h1>Masuk</h1>
    <div class="subtitle">// akses dashboard</div>

    <?php if($error): ?>
    <div class="error-box"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="csrf_token" value="<?= CSRF::GenerateCsrftoken() ?>">

        <div class="field">
            <label>Username</label>
            <input type="text" name="username" placeholder="masukkan username" autofocus>
        </div>

        <div class="field">
            <label>Password</label>
            <input type="password" name="password" placeholder="••••••••">
        </div>

        <button type="submit" name="login" class="btn-primary">Login</button>
    </form>

    <div class="footer-link">
        Belum punya akun? <a href="index.php?action=register">Daftar</a>
    </div>
</div>
</body>
</html>
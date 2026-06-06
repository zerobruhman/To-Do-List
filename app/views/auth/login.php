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
            align-items: center;
            justify-content: center;
        }

        .card {
            width: 100%;
            max-width: 380px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 36px 32px;
            animation: fadeUp 0.3s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 28px;
        }

        .brand-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: var(--accent);
            box-shadow: 0 0 8px var(--accent);
        }

        .brand-name {
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.04em;
        }

        h1 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .subtitle {
            font-size: 13px;
            color: var(--text3);
            font-family: var(--mono);
            margin-bottom: 28px;
        }

        .error-box {
            background: var(--danger-dim);
            border: 1px solid rgba(255,77,77,0.25);
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 13px;
            color: var(--danger);
            margin-bottom: 20px;
            font-family: var(--mono);
        }

        .field {
            margin-bottom: 16px;
        }

        label {
            display: block;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text3);
            font-family: var(--mono);
            margin-bottom: 6px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px 14px;
            background: var(--surface2);
            border: 1px solid var(--border2);
            border-radius: 8px;
            color: var(--text);
            font-family: var(--mono);
            font-size: 13px;
            outline: none;
            transition: border-color 0.15s;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: var(--accent);
        }

        input::placeholder { color: var(--text3); }

        .btn-primary {
            width: 100%;
            padding: 11px;
            background: var(--accent);
            border: none;
            border-radius: 8px;
            color: #fff;
            font-family: var(--sans);
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            margin-top: 8px;
            transition: opacity 0.15s;
            letter-spacing: 0.02em;
        }

        .btn-primary:hover { opacity: 0.85; }

        .footer-link {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: var(--text3);
        }

        .footer-link a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
        }

        .footer-link a:hover { text-decoration: underline; }
    </style>
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
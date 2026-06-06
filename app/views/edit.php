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
            max-width: 400px;
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

        .back-link {
            font-size: 13px;
            color: var(--text3);
            text-decoration: none;
            font-family: var(--mono);
            margin-left: auto;
            transition: color 0.15s;
        }

        .back-link:hover { color: var(--accent); }

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

        .field { margin-bottom: 16px; }

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
        input[type="password"]:focus { border-color: var(--accent); }

        input::placeholder { color: var(--text3); }

        .btn-row {
            display: flex;
            gap: 10px;
            margin-top: 8px;
        }

        .btn-primary {
            flex: 1;
            padding: 11px;
            background: var(--accent);
            border: none;
            border-radius: 8px;
            color: #fff;
            font-family: var(--sans);
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: opacity 0.15s;
        }

        .btn-primary:hover { opacity: 0.85; }

        .btn-secondary {
            padding: 11px 18px;
            background: transparent;
            border: 1px solid var(--border2);
            border-radius: 8px;
            color: var(--text2);
            font-family: var(--sans);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.15s;
        }

        .btn-secondary:hover {
            border-color: var(--text2);
            color: var(--text);
        }
    </style>
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
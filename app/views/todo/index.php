<?php
require_once __DIR__ . "/../../../core/CSRF.php";
$todos = $todos ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
</head>
<body>
    <h1>Selamat datang di TDL!</h1>
    <h2>Tambahkan Todo</h2>
    <form method="POST" action="index.php?action=todo-store">
        <input type="hidden" name="csrf_token" value="<?= CSRF::GenerateCsrftoken() ?>">
        <div>
            <label>Judul</label><br>
            <input type="text" name="judul" required> <br>
        </div>
        <br>
        <div>
            <label>Deskripsi</label><br>
            <textarea rows="4" name="deskripsi"></textarea> 
        </div>
        <br>
        <button type="submit">Buat</button>
    </form>

    <h2>Daftar Todo</h2>
    <?php foreach ($todos as $todo):?>
        <div style="border: 10px solid #ccc; padding: 10px; margin-bottom: 10px;">
            <h3>
                <?php if ($todo['status'] == 'selesai'): ?>
                    ✅
                <?php else: ?>
                    ⬜
                <?php endif?>
                
                <?= htmlspecialchars($todo['judul']) ?>
            </h3>

            <p> <?= nl2br($todo['deskripsi']) ?></p>
            <small>Status: <?= htmlspecialchars($todo['status']) ?></small>
            <form method="POST" action="index.php?action=todo-toggle">
                 <input type="hidden" name="csrf_token" value=<?= CSRF::GenerateCsrftoken() ?>>
                 <input type="hidden" name="todo_id" value=<?= $todo['id'] ?>>
                 <button type="submit">Toggle</button>
            </form>
        </div>
    <?php endforeach?>
</body>
</html>
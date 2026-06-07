<?php
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
    <form method="POST" action="index.php?action=todo-store">
        Judul: <input type="text" name="judul">
        Deskripsi: <input type="text" name="deskripsi">
        <button type="submit" name="buat">Buat</button>
    </form>
    <?php foreach ($todos as $todo):?>
    <h2>Judul: <?= htmlspecialchars($todo['judul']) ?></h2>
    <p>Deskripsi: <?= htmlspecialchars($todo['deskripsi']) ?></p>
    <p>Status: <?= $todo['status'] ?></p>
    <?php endforeach?>
</body>
</html>
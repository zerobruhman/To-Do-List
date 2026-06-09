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
    <h2>Tambahkan Todo</h2>
    <form method="POST" action="index.php?action=todo-store">
        Judul: <input type="text" name="judul"> <br>
        Deskripsi: <input type="text" name="deskripsi"> <br>
        <button type="submit" name="buat">Buat</button>
    </form>

    <h2>Daftar Todo</h2>
    <?php foreach ($todos as $todo):?>
    <h3>Judul: <?= htmlspecialchars($todo['judul']) ?></h2>
    <p>Deskripsi: <?= htmlspecialchars($todo['deskripsi']) ?></p>
    <p>Status: <?= $todo['status'] ?></p>
    <button>Edit</button> <input type="checkbox"> <button>Hapus</button> 
    <?php endforeach?>
</body>
</html>
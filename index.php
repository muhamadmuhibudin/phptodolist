<?php

$todos = [];
$file = file_get_contents('todo.txt');
$todos = unserialize($file);

//fungsi untuk melihat apakah data sudah ada update, ketika ada maka dia akan membaca data terbaru (tanpa hapus)

if(isset($POST['todo'])){
    $data = $POST['todo']
    $todos[] = [
        'todo' => $data
        'status' => 0
    ];
    file_put_contents('todo.txt'.serialize($todos));
}

?>

<h1>TODO LIST HARI INI</h1>

<form method="POST">
    <label> Apa kegiatanmu hari ini ? </label> <br>
    <input type="text" name="todo">
    <button type="submit"></button>
</form>

<ul>
    <li>
        <input type="checkbox" name"todo[]">
        <label>Tugas hari ini</label>
        <a href="#">Hapus</a>
    </li>
    <li>
        <input type="checkbox" name"todo[]">
        <label>Tugas hari ini</label>
        <a href="#">Hapus</a>
    </li>
    <li>
        <input type="checkbox" name"todo[]">
        <label>Tugas hari ini</label>
        <a href="#">Hapus</a>
    </li>
    <li>
        <input type="checkbox" name"todo[]">
        <label>Tugas hari ini</label>
        <a href="#">Hapus</a>
    </li>
</ul>
<?php
//total array yang disiapkan untuk disimpan
$todos	= []; 
//Jika ditemukan todo yang dikirim melalui methode POST
if(isset($_POST['todo']))
{
    $data	= $_POST['todo']; // mengambil data yang diinput pada form
    $todos[]=[
                'todo'	=> $data,
                'status'=>0
    		  ];
	$daftar_belanja=serialize($todos);//simpan daftar belanja dalam format serialized
    file_put_contents('todo.txt',$daftar_belanja);
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
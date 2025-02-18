<?php

//total array yang disiapkan untuk disimpan
$todos	= []; 
if(file_exists('todo.txt')){
$file = file_get_contents('todo.txt');
$todos = unserialize($file);
}

//Jika ditemukan todo yang dikirim melalui methode POST

if(isset($_POST['todo']))
{
    $data	= $_POST['todo']; // mengambil data yang diinput pada form
    $todos[]=[
                'todo'	=> $data,
                'status'=>0
    		  ];
	$daftar_belanja=serialize($todos);//simpan daftar belanja dalam format serialized
    file_put_contents('todo.txt',serialize($todos));
}

?>

<h1>TODO LIST HARI INI</h1>

<form method="POST">
    <label> Apa kegiatanmu hari ini ? </label> <br>
    <input type="text" name="todo">
    <button type="submit">SIMPAN</button>
</form>

<ul>
    <?php foreach($todos as $key => $value): ?>
    <li>
        <input type="checkbox" name="todo">
        <label><?php echo $value['todo']; ?></label>
        <a href="#">Hapus</a>
    </li>
    <?php endforeach; ?>
   
</ul>
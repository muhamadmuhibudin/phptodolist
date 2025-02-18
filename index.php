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
    header('Location:index.php');
}

// fungsi untuk checkbox agar tidak salah marking
if(isset($_GET['status'])){
    $todos[$_GET['key']]['status'] = $_GET['status'];
    file_put_contents('todo.txt', serialize($todos));
    header('Location:index.php');
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
        <input type="checkbox" name="todo" onclick="window.location.href = 'index.php?status=<?php 
        echo ($value['status'] == 1) ? '0' : '1'; ?>&key=<?php echo $key; ?>'" 
        <?php if($value['status'] == 1) echo 'CHECKED'; ?> >
        <label>
            <?php 
        if($value['status'] == 1)  echo '<del>' .$value['todo']. '<del>'; 
        else echo $value['todo'] 
        ?>
       </label>
        <a href="#">Hapus</a>
    </li>
    <?php endforeach; ?>
   
</ul>
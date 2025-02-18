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
    saveData($todos);
}

// fungsi untuk checkbox agar tidak salah marking
if(isset($_GET['status'])){
    $todos[$_GET['key']]['status'] = $_GET['status'];
    saveData($todos);
}

// kode untu tangkap hapus dan key nya

if(isset($_GET['hapus'])){
    unset($todos[$_GET['key']]);
    saveData($todos);
}

// 2 hal penting 1. pada saat proses hapus harus ada konfirmasi 2.ada beberapa kode yang berulang, put contents dan headernya, maka buat fungsi untuk panggil proses tersebut agar lebih mudah
// fungsi untuk memepermudah poin ke dua

function saveData($todos){
    file_put_contents('todo.txt', serialize($todos));
    header('Location:index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TODO List</title>
    <!-- Tambahkan link ke file CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

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
        <a href="index.php?hapus=1&key=<?php echo $key ?>" 
        onclick="return confirm('Apa yakin akan menghapus todo ini ?')">Hapus</a>
    </li>
    <?php endforeach; ?>

<!-- baris terakhir dari del adalah untuk konfirmasi ke user apakah akan di hapus atau hanya salah klik saja -->
   
</ul>

</body>
</html>
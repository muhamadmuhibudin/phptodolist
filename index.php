<?php

$todos	= []; 
if(file_exists('todo.txt')){
$file = file_get_contents('todo.txt');
$todos = unserialize($file);
if (!is_array($todos)) { 
        $todos = [];
    }
}

if (isset($_POST['todo'])) {
    $data = trim($_POST['todo']);
    if (!empty($data)) { 
        $todos[] = [
            'todo' => $data,
            'status' => 0
        ];
        saveData($todos);
        exit();
    } else {
        echo "<script>alert('Kegiatan tidak boleh kosong !');</script>";
    }
}

if(isset($_POST['todo']))
{
    $data	= $_POST['todo'];
    $todos[]=[
                'todo'	=> $data,
                'status'=>0
    		  ];
	$daftar_belanja=serialize($todos);
    saveData($todos);
}

// edit todo 

if (isset($_POST['todo']) && isset($_POST['edit_key'])) {
    $data = trim($_POST['todo']);
    $edit_key = $_POST['edit_key'];

    if (!empty($data) && isset($todos[$edit_key])) { 
        $todos[$edit_key]['todo'] = $data;
        saveData($todos);
    } else {
        echo "<script>alert('Kegiatan tidak boleh kosong atau Todo tidak ditemukan!');</script>";
    }
} elseif (isset($_POST['todo'])) { 
    $data = trim($_POST['todo']);
    if (!empty($data)) {
        $todos[] = [
            'todo' => $data,
            'status' => 0
        ];
        saveData($todos);
    } else {
        echo "<script>alert('Kegiatan tidak boleh kosong !');</script>";
    }
}


// fungsi untuk checkbox agar tidak salah marking
if(isset($_GET['status']) && isset($_GET['key']) && isset($todos[$_GET['key']])) {
    $todos[$_GET['key']]['status'] = $_GET['status'];
    saveData($todos);
}


// kode untuk tangkap dan hapus key nya

if(isset($_GET['hapus']) && isset($_GET['key']) && isset($todos[$_GET['key']])) {
    unset($todos[$_GET['key']]);
    $todos = array_values($todos); // Reset indeks setelah hapus
    saveData($todos);
}


// 2 hal penting 1. pada saat proses hapus harus ada konfirmasi 2.ada beberapa kode yang berulang, put contents dan headernya, maka buat fungsi untuk panggil proses tersebut agar lebih mudah
// fungsi untuk memepermudah poin ke dua

function saveData($todos){
    file_put_contents('todo.txt', serialize($todos));
    header('Location:index.php');
    exit();
}

// Filter todo berdasarkan status
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$filtered_todos = array_values(array_filter($todos, function($todo) use ($filter) {
    if (isset($todo['status'])) {
        if ($filter == 'completed') {
            return $todo['status'] == 1;
        } elseif ($filter == 'incomplete') {
            return $todo['status'] == 0;
        }
    }
    return true;
}));



// Pagination
$per_page = 10; 
$total_todos = count($filtered_todos);
$total_pages = max(1, ceil($total_todos / $per_page));
$current_page = isset($_GET['page']) ? max(1, min($_GET['page'], $total_pages)) : 1;
$offset = ($current_page - 1) * $per_page;
$paginated_todos = array_slice($filtered_todos, $offset, $per_page);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TODO List</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function validateForm() {
            var input = document.forms["todoForm"]["todo"].value.trim();
            if (input == "") {
                alert("Kegiatan tidak boleh kosong !");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>

<h1>TODO LIST HARI INI</h1>

<form method="POST" name="todoForm" onsubmit="return validateForm()">
    <input type="text" name="todo" 
           value="<?php echo isset($_GET['edit_key']) && isset($todos[$_GET['edit_key']]) ? htmlspecialchars($todos[$_GET['edit_key']]['todo']) : ''; ?>">
    
    <?php if (isset($_GET['edit_key']) && isset($todos[$_GET['edit_key']])): ?>
        <input type="hidden" name="edit_key" value="<?php echo $_GET['edit_key']; ?>">
        <button type="submit">Update</button>
        <a href="index.php">Batal</a>
    <?php else: ?>
        <button type="submit">SIMPAN</button>
    <?php endif; ?>
</form>



<div>
    <strong>Filter :</strong>
    <a href="index.php?filter=all">Semua</a> |
    <a href="index.php?filter=completed">Selesai</a> |
    <a href="index.php?filter=incomplete">Belum Selesai</a>
</div>

<ul>
    <?php foreach ($paginated_todos as $display_index => $value): ?>
    <?php $original_index = array_search($value, $todos, true); ?> <!-- Cari indeks asli -->
    <li>
        <input type="checkbox" name="todo" 
               onclick="window.location.href = 'index.php?status=<?php 
               echo ($value['status'] == 1) ? '0' : '1'; ?>&key=<?php echo $original_index; ?>'" 
               <?php if($value['status'] == 1) echo 'CHECKED'; ?> >
        <label>
            <?php 
            if ($value['status'] == 1)  
                echo '<del>' . htmlspecialchars($value['todo']) . '</del>'; 
            else 
                echo htmlspecialchars($value['todo']);
            ?>
        </label>
        <a href="index.php?edit_key=<?php echo $original_index; ?>">Edit</a>
        <a href="index.php?hapus=1&key=<?php echo $original_index; ?>" 
           onclick="return confirm('Apa yakin akan menghapus todo ini ?')">Hapus</a>
    </li>
    <?php endforeach; ?>

<!-- baris terakhir dari del adalah untuk konfirmasi ke user apakah akan di hapus atau hanya salah klik saja -->
   
</ul>
<!-- tambahan fitur untuk paginasi ( setiap berapa todo maka dia akan di split ) -->
<div>
    <?php if ($total_pages > 1): ?>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="index.php?page=<?php echo $i; ?>&filter=<?php echo $filter; ?>" 
               <?php if ($i == $current_page) echo 'style="font-weight:bold;"'; ?>>
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>
    <?php endif; ?>
</div>

</body>
</html>
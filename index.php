<?php
    require_once('koneksi.php');
    $getPendaftaran = mysqli_query($koneksi,"SELECT * FROM pendaftaran");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Belajar CRUD</title>
</head>
<body>
    <a href="create.php">Tambah Data</a>
    <br>
    <table border="1" style="width:100%;text-align:center">
        <thead>
            <th>#</th>
            <th>No Pendaftaran</th>
            <th>Bukti</th>
            <th>Aksi</th>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            while($data = mysqli_fetch_array($getPendaftaran)): ?>
                <tr>
                    <td><?=$no?></td>
                    <td><?=$data['no_pendaftaran']?></td>
                    <td>
                        <img width="200px" src="<?=$baseUrl.'/'.$data['bukti']?>" alt="" srcset="">
                    </td>
                    <td>
                    <a href="edit.php?id=<?=$data['id']?>">Edit</a>
                    <button onclick="myFunc(<?=$data['id']?>)">Hapus</button>
                    </td>
                </tr>
                <?php 
            $no++;
            endwhile; ?>
        </tbody>
    </table>
    <script>
        function myFunc(id) {
            var res = confirm("Yakin ingin menghapus?");
            if(res){
                window.location.href = 'delete.php?id='+id
            }
        }
    </script>
</body>
</html>
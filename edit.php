<?php
    require_once('koneksi.php');
    $id = $_GET['id'];
    if(!isset($id)){
        header('Location: index.php');
        exit;
    }else{
        $data = mysqli_query($koneksi,"SELECT * FROM pendaftaran WHERE id='$id'");
        $data = mysqli_fetch_array($data);
        if(!$data){
            header('Location: index.php');
            exit;
        }
    }
    if(isset($_POST['update'])){
        $no_pendaftaran = $_POST['no_pendaftaran'];
        $bukti = $_FILES['bukti'];
        if($bukti['error'] == 4){
            $cek = mysqli_query($koneksi,"SELECT * FROM pendaftaran WHERE no_pendaftaran=$no_pendaftaran");
            if(mysqli_fetch_array($cek) > 0 && $no_pendaftaran != $data['no_pendaftaran']){
                echo '<script language="javascript">';
                echo 'alert("No Pendaftaran sudah ada")';
                echo '</script>';
            }else{
                $update = mysqli_query($koneksi,"UPDATE pendaftaran SET no_pendaftaran='$no_pendaftaran' WHERE id=$id");
                if($update){
                    header('Location: index.php');
                    exit;
                }else{
                    echo '<script language="javascript">';
                    echo 'alert("Gagal mengubah data")';
                    echo '</script>';
                }
            }
        }else{
            // cek file size 1MB
            $sizeFile = 1;
            if(($_FILES['bukti']['size'] / 1024) > ($sizeFile * 1024)){
                echo '<script language="javascript">';
                echo 'alert("File harus kurang dari '.$sizeFile.'MB")';
                echo '</script>';
            }else{
                [$namaFile,$typeFile] = explode('.',$_FILES["bukti"]["name"]);
                $extensionAccept = ['jpg','jpeg','png'];
                if(in_array($typeFile,$extensionAccept)){
                    $target_dir = "uploads/";
                    $filename = md5( uniqid() . $namaFile . rand(0,100)).".".$typeFile;
                    $target_upload = $target_dir.$filename;
                    $upload = move_uploaded_file($_FILES['bukti']['tmp_name'],$target_upload);
                    if($upload){
                        $updateData = mysqli_query($koneksi,"UPDATE pendaftaran SET bukti='$target_upload' WHERE id=$id");
                        if($updateData){
                            unlink($data['bukti']);
                            echo '<script language="javascript">';
                            echo 'window.location.href = "index.php"';
                            echo '</script>';
                        }else{
                            echo '<script language="javascript">';
                            echo 'alert("Gagal mengubah bukti")';
                            echo '</script>';
                        }
                    }else{
                        echo '<script language="javascript">';
                        echo 'alert("Gagal mengubah bukti")';
                        echo '</script>';
                    }
                }else{
                    echo '<script language="javascript">';
                    echo 'alert("Maaf bukti yang diperbolehkan harus file '.implode(', ',$extensionAccept).'")';
                    echo '</script>';
                }
            }
        }
        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="no_pendaftaran">No Pendaftaran</label>
        <input type="text" name="no_pendaftaran" id="no_pendaftaran" value="<?=$data['no_pendaftaran']?>">
        <label for="bukti">Bukti</label>
        <input type="file" name="bukti" id="bukti" value="<?=$data['bukti']?>">
        <button type="submit" name="update">
            Simpan
        </button>
    </form>
</body>
</html>
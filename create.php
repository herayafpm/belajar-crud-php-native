<?php
    require_once('koneksi.php');
    if(isset($_POST['tambah'])){
        $no_pendaftaran = $_POST['no_pendaftaran'];
        if($no_pendaftaran != ""){
            $cek = mysqli_query($koneksi,"SELECT * FROM pendaftaran WHERE no_pendaftaran=$no_pendaftaran");
            if(mysqli_fetch_array($cek) > 0){
                echo '<script language="javascript">';
                echo 'alert("No Pendaftaran sudah ada")';
                echo '</script>';
            }else{
                $check = getimagesize($_FILES["bukti"]["tmp_name"]);
                if($check !== false) {
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
                                $insertData = mysqli_query($koneksi,"INSERT INTO pendaftaran(no_pendaftaran,bukti) VALUES('$no_pendaftaran','$target_upload')");
                                if($insertData){
                                    echo '<script language="javascript">';
                                    echo 'window.location.href = "index.php"';
                                    echo '</script>';
                                }else{
                                    echo '<script language="javascript">';
                                    echo 'alert("Gagal mengirim bukti")';
                                    echo '</script>';
                                }
                            }else{
                                echo '<script language="javascript">';
                                echo 'alert("Gagal mengirim bukti")';
                                echo '</script>';
                            }
                        }else{
                            echo '<script language="javascript">';
                            echo 'alert("Maaf bukti yang diperbolehkan harus file '.implode(', ',$extensionAccept).'")';
                            echo '</script>';
                        }
                    }
                } else {
                    echo '<script language="javascript">';
                    echo 'alert("Silahkan sediakan bukti pembayaran")';
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
    <title>Tambah Data</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="no_pendaftaran">No Pendaftaran</label>
        <input type="text" name="no_pendaftaran" id="no_pendaftaran">
        <label for="bukti">Bukti</label>
        <input type="file" name="bukti" id="bukti">
        <button type="submit" name="tambah">
            Simpan
        </button>
    </form>
</body>
</html>
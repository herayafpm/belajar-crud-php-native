<?php
    require_once('koneksi.php');
    $id = $_GET['id'];
    if(!isset($id)){
        header("Location: index.php");
        exit;
    }else{
        $getData = mysqli_query($koneksi,"SELECT * FROM pendaftaran WHERE id=$id");
        $getData = mysqli_fetch_array($getData);
        if($getData){
            $delete = mysqli_query($koneksi,"DELETE FROM pendaftaran WHERE id=$id");
            if($delete){
                unlink($getData['bukti']);
            }
            header("Location: index.php");
            exit;
        }else{
            header("Location: index.php");
            exit;
        }
    }
?>
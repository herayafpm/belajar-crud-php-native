<?php
$baseUrl = "http://localhost/belajar-crud";
// biasanaya di xampp windows username = root dan password kosong
// $koneksi = mysqli_connect("localhost","root","","nama_database");
$koneksi = mysqli_connect("localhost","username","password","nama_database");

if(mysqli_connect_errno()){
    echo "Koneksi gagal";
}

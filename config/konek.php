<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project_elearning";

// untuk menghubungan dengan database
$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn){
    die("Koneksi Gagal: " . mysqli_connect_error());
}else{
    //echo "Koneksi berhasil<br>";
}

?>
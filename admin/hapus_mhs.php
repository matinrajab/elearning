<?php
include'../config/konek.php';

if(isset($_GET['nrp'])){
	$nrp = $_GET['nrp'];

	//melakukan query ke database, dengan cara SELECT data yang memiliki id yang sama dengan variabel $id
	$sql_mhs = "SELECT * FROM mahasiswa WHERE nrp='$nrp'";
    $result_mhs = mysqli_query($conn, $sql_mhs);
	$row_mhs = mysqli_fetch_assoc($result_mhs);
	$nama = $row_mhs['nama'];

	//jika query menghasilkan nilai > 0 maka eksekusi script di bawah
	if(mysqli_num_rows($result_mhs) > 0){
		//query ke database DELETE untuk menghapus data dengan kondisi nrp=$nrp
		$sql_mhs = "DELETE FROM mahasiswa WHERE nrp='$nrp'";
		$sql_akun = "DELETE FROM akun WHERE nama='$nama'";
		if(mysqli_query($conn, $sql_mhs) && mysqli_query($conn, $sql_akun)){
			echo '<script>alert("Berhasil menghapus data '.$nrp.'"); document.location="index.php?page=tampil_mhs";</script>';
		}else{
			echo '<script>alert("Gagal menghapus data '.$nrp.'"); document.location="index.php?page=tampil_mhs";</script>';
		}
	}else{
		echo '<script>alert("'.$nrp.' tidak ditemukan di database."); document.location="index.php?page=tampil_mhs";</script>';
	}
}
?>
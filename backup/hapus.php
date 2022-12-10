<?php
include'config/konek.php';

if(isset($_GET['nrp'])){
	$nrp = $_GET['nrp'];

	//melakukan query ke database, dengan cara SELECT data yang memiliki id yang sama dengan variabel $id
	$sql = "SELECT * FROM mahasiswa WHERE nrp='$nrp'";
    $result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);

	//jika query menghasilkan nilai > 0 maka eksekusi script di bawah
	if(mysqli_num_rows($result) > 0){
		//query ke database DELETE untuk menghapus data dengan kondisi nrp=$nrp
		$sql = "DELETE FROM mahasiswa WHERE nrp='$nrp'";
		if(mysqli_query($conn, $sql)){
			//jika perintah sql berhasil, hapus gambar pada folder image
			unlink("image/".$row['foto']);

			echo '<script>alert("Berhasil menghapus data '.$nrp.'"); document.location="index.php?page=tampil_data";</script>';
		}else{
			echo '<script>alert("Gagal menghapus data '.$nrp.'"); document.location="index.php?page=tampil_data";</script>';
		}
	}else{
		echo '<script>alert("'.$nrp.' tidak ditemukan di database."); document.location="index.php?page=tampil_data";</script>';
	}
}
?>
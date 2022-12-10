<?php
include'../config/konek.php';

if(isset($_GET['nip'])){
	$nip = $_GET['nip'];

	//melakukan query ke database, dengan cara SELECT data yang memiliki id yang sama dengan variabel $id
	$sql_dosen = "SELECT * FROM dosen WHERE nip='$nip'";
    $result_dosen = mysqli_query($conn, $sql_dosen);
	$row_dosen = mysqli_fetch_assoc($result_dosen);
	$nama = $row_dosen['nama'];

	//jika query menghasilkan nilai > 0 maka eksekusi script di bawah
	if(mysqli_num_rows($result_dosen) > 0){
		//query ke database DELETE untuk menghapus data dengan kondisi nip=$nip
		$sql_dosen = "DELETE FROM dosen WHERE nip='$nip'";
		$sql_akun = "DELETE FROM akun WHERE nama='$nama'";
		if(mysqli_query($conn, $sql_dosen) && mysqli_query($conn, $sql_akun)){
			echo '<script>alert("Berhasil menghapus data '.$nip.'"); document.location="index.php?page=tampil_dosen";</script>';
		}else{
			echo '<script>alert("Gagal menghapus data '.$nip.'"); document.location="index.php?page=tampil_dosen";</script>';
		}
	}else{
		echo '<script>alert("'.$nip.' tidak ditemukan di database."); document.location="index.php?page=tampil_dosen";</script>';
	}
}
?>
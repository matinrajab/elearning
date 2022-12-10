<?php
    session_start();

    include '../config/konek.php';

    if (isset($_SESSION['id_tugas'])) {
        $id_tugas = $_SESSION['id_tugas'];
    }

    if(isset($_GET['nrp'])){
        $nrp = $_GET['nrp'];

        $sql_mhs = "SELECT * FROM mahasiswa WHERE nrp='$nrp'";
        $result_mhs = mysqli_query($conn, $sql_mhs);

        if(mysqli_num_rows($result_mhs) == 0){
            echo '<div class="alert alert-warning">'.$nrp.' tidak ada dalam database.</div>';
            exit();
        }

        $row_mhs = mysqli_fetch_assoc($result_mhs);

        $sql_tugas = "SELECT * FROM tugas_mhs WHERE nrp='$nrp' AND id_tugas=$id_tugas";
        $result_tugas = mysqli_query($conn, $sql_tugas);

        if(mysqli_num_rows($result_tugas) > 0){
            $row_tugas = mysqli_fetch_assoc($result_tugas);
        }
    }

    if(isset($_POST['submit_ubah'])){
        $nilai = $_POST["nilai"];

        //update data tugas_mhs
        $sql_nilai = "UPDATE tugas_mhs SET nilai=$nilai WHERE nrp='$nrp' AND id_tugas=$id_tugas";

        if(mysqli_query($conn, $sql_nilai)){
            echo "<script>alert('Nilai berhasil diberikan');
            document.location='index.php?page=pengumpulan&id_tugas=$id_tugas'; </script>";
        }else{
            echo '<div class="alert alert-warning">Gagal melakukan proses penilaian.</div>';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
</head>

<body class="bg-light">
    <div class="container" style="margin-top:20px">
		<center><font size="6">Penilaian Tugas</font></center>
		<hr>
		<form action="" method="post">
			<div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">NRP</label>
                <div class="col-md-6 col-sm-6">
                    <input type="number" name="nrp" class="form-control" value="<?php echo $row_mhs['nrp']; ?>" autocomplete="off" required readonly>
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">Nama Mahasiswa</label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="nama" class="form-control" value="<?php echo $row_mhs['nama']; ?>" autocomplete="off" required readonly>
                </div>
            </div>
			<div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">Nilai</label>
                <div class="col-md-6 col-sm-6">
                    <input type="number" name="nilai" class="form-control" value="<?php echo $row_tugas['nilai']; ?>" autocomplete="off" required>
                </div>
            </div>
            <div class="item form-group">
                <div class="col-md-6 col-sm-6 offset-md-3">
                    <input type="submit" name="submit_ubah" class="btn btn-primary" value="Simpan">
                    <a href="index.php?page=pengumpulan&id_tugas=<?php echo $id_tugas; ?>" class="btn btn-warning">Kembali</a>
                </div>
            </div>
		</form>
	</div>
</body>

</html>
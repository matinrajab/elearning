<?php
    session_start();

    include '../config/konek.php';

    if (isset($_SESSION['matkul'])) {
        $matkul = $_SESSION['matkul'];
    }

    if(isset($_GET['id_tugas'])){
        $id_tugas = $_GET['id_tugas'];

        $sql_list_tugas = "SELECT * FROM list_tugas WHERE id_tugas=$id_tugas";
        $result_list_tugas = mysqli_query($conn, $sql_list_tugas);

        if(mysqli_num_rows($result_list_tugas) == 0){
            echo '<div class="alert alert-warning">'.$nrp.' tidak ada dalam database.</div>';
            exit();
        }

        $row_list_tugas = mysqli_fetch_assoc($result_list_tugas);
    }

    if(isset($_POST['submit_ubah'])){
        //ambil nama mhs dari cookie
        $nama = str_replace('%20', ' ', $_COOKIE['name']);
        $sql_mhs = "SELECT * FROM mahasiswa
                    WHERE nama = '$nama'";
        $result_mhs = mysqli_query($conn, $sql_mhs);
        $row_mhs = mysqli_fetch_assoc($result_mhs);
        //ambil nrp dari database mahasiswa
        $nrp = $row_mhs['nrp'];

        $file_name = $_FILES['file_mhs']['name'];
        $file_tmp = $_FILES['file_mhs']['tmp_name'];
        $file_size = $_FILES['file_mhs']['size'];

        // upload file
        move_uploaded_file($file_tmp, '../file_tugas/' . $file_name);

        //menambahkan data tugas_mhs
        $sql_tugas = "INSERT INTO tugas_mhs
        VALUES ($id_tugas, '$nrp', NULL, '$file_name')";
        if(mysqli_query($conn, $sql_tugas)){
            echo '<script>alert("Tugas berhasil dikumpulkan");
            document.location="index.php?page=list_tugas&matkul='.$matkul.'";</script>';
        }else{
            echo "<script>alert('Tugas gagal ditambahkan');</script>";
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
		<center><font size="6">Pengumpulan Tugas</font></center>
		<hr>
		<form action="" method="post" enctype="multipart/form-data">
			<div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">Mata Kuliah</label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="matkul" class="form-control" value="<?php echo $row_list_tugas['matkul']; ?>" autocomplete="off" required readonly>
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">Judul Tugas</label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="judul" class="form-control" value="<?php echo $row_list_tugas['judul']; ?>" autocomplete="off" required readonly>
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">Deadline</label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="deadline" class="form-control" value="<?php echo $row_list_tugas['deadline']; ?>" autocomplete="off" required readonly>
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">Tugas Anda</label>
                <div class="col-md-6 col-sm-6">
                    <input type="file" name="file_mhs" required>
                </div>
            </div>
            <div class="item form-group">
                <div class="col-md-6 col-sm-6 offset-md-3">
                    <input type="submit" name="submit_ubah" class="btn btn-primary" value="Submit">
                    <a href="index.php?page=list_tugas&matkul=<?php echo $matkul; ?>" class="btn btn-warning">Kembali</a>
                </div>
            </div>
		</form>
	</div>
</body>

</html>
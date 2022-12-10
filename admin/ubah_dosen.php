<?php
    include '../config/konek.php';

    if(isset($_GET['nip'])){
        $nip = $_GET['nip'];
        $nip_lama = $nip;

        $sql_dosen = "SELECT * FROM dosen WHERE nip='$nip'";
        $result_dosen = mysqli_query($conn, $sql_dosen);

        if(mysqli_num_rows($result_dosen) == 0){
            echo '<div class="alert alert-warning">'.$nip.' tidak ada dalam database.</div>';
            exit();
        }

        $row_dosen = mysqli_fetch_assoc($result_dosen);
        $nama = $row_dosen['nama'];
        
        $sql_akun = "SELECT * FROM akun WHERE nama='$nama'";
        $result_akun = mysqli_query($conn, $sql_akun);
        $row_akun = mysqli_fetch_assoc($result_akun);
        $username_lama = $row_akun['username'];
        $password_lama = $row_akun['password'];
    }

    if(isset($_POST['submit_ubah'])){
        $nip = $_POST["nip"];
        $nama = $_POST["nama"];
        $matkul = $_POST["matkul"];
        $jenis_kelamin = $_POST["jenis_kelamin"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        
        //cek apakah password diganti
        if($password !== $password_lama){
            //mengenkripsi password
            $password = md5($password);
        }

        //update data dosen
        $sql_dosen = "UPDATE dosen SET nip='$nip', nama='$nama', matkul='$matkul', jenis_kelamin='$jenis_kelamin' WHERE nip='$nip_lama'";
        
        //update akun dosen
        $sql_akun = "UPDATE akun SET nama='$nama', username='$username', password='$password' WHERE username='$username_lama'";

        if(mysqli_query($conn, $sql_dosen) && mysqli_query($conn, $sql_akun)){
            echo "<script>alert('Data berhasil diperbarui');
            document.location='index.php?page=tampil_dosen'; </script>";
        }else{
            echo '<div class="alert alert-warning">Gagal melakukan proses edit data.</div>';
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
		<center><font size="6">Edit Data Dosen</font></center>
		<hr>
		<form action="" method="post" enctype="multipart/form-data">
			<div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">NIP</label>
                <div class="col-md-6 col-sm-6">
                    <input type="number" name="nip" class="form-control" value="<?php echo $row_dosen['nip']; ?>" autocomplete="off" required>
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">Nama Dosen</label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="nama" class="form-control" value="<?php echo $row_dosen['nama']; ?>" autocomplete="off" required>
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">Mata Kuliah</label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="matkul" class="form-control" value="<?php echo $row_dosen['matkul']; ?>" autocomplete="off" required>
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">Jenis Kelamin</label>
                <div class="col-md-6 col-sm-6">
                    <select name="jenis_kelamin" class="form-control" required>
                        <option value="Laki-laki" <?php if($row_dosen['jenis_kelamin'] == 'Laki-laki'){ echo 'selected'; } ?>>Laki-laki</option>
                        <option value="Perempuan" <?php if($row_dosen['jenis_kelamin'] == 'Perempuan'){ echo 'selected'; } ?>>Perempuan</option>
                    </select>
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">Username</label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="username" class="form-control" value="<?php echo $row_akun['username']; ?>" autocomplete="off" required>
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">Password</label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="password" class="form-control" value="<?php echo $row_akun['password']; ?>" autocomplete="off" required>
                    <i>Abaikan jika tidak merubah password. Jika ingin merubah tulis saja yg baru, password akan otomatis terenkripsi</i>
                </div>
            </div>
            <div class="item form-group">
                <div class="col-md-6 col-sm-6 offset-md-3">
                    <input type="submit" name="submit_ubah" class="btn btn-primary" value="Simpan">
                    <a href="index.php?page=tampil_dosen" class="btn btn-warning">Kembali</a>
                </div>
            </div>
		</form>
	</div>
</body>

</html>
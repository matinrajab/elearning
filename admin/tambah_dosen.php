<?php
    include '../config/konek.php';
    
    if(isset($_POST["submit_tambah"])){
        $nip = $_POST["nip"];
        $nama = $_POST["nama"];
        $matkul = $_POST["matkul"];
        $jenis_kelamin = $_POST["jenis_kelamin"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $level = "dosen";
        
		//mengenkripsi password
		$password = md5($password);

        //menambahkan data dosen ke database
        $sql_dosen = "INSERT INTO dosen
        VALUES ('$nip', '$nama', '$matkul', '$jenis_kelamin')";
        //menambahkan akun dosen ke database
        $sql_akun = "INSERT INTO akun
        VALUES ('$nama', '$username', '$password', '$level')";
        if(mysqli_query($conn, $sql_dosen) && mysqli_query($conn, $sql_akun)){
            echo "<script>alert('Data berhasil ditambahkan');
            document.location='index.php?page=tampil_dosen';</script>";
        }else{
            echo "<script>alert('Data gagal ditambahkan');</script>";
        }
    }    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data</title>
</head>

<body class="bg-light">
    <div class="container" style="margin-top:20px">
        <center>
            <font size="6">Tambah Data Dosen</font>
        </center>
        <hr>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">NIP</label>
                <div class="col-md-6 col-sm-6 ">
                    <input type="number" name="nip" class="form-control" autocomplete="off" required>
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">Nama Dosen</label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="nama" class="form-control" autocomplete="off" required>
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">Mata Kuliah</label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="matkul" class="form-control" autocomplete="off" required>
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">Jenis Kelamin</label>
                <div class="col-md-6 col-sm-6">
                    <select name="jenis_kelamin" class="form-control" required>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">Username</label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="username" class="form-control" autocomplete="off" required>
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">Password</label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="password" class="form-control" autocomplete="off" required>
                </div>
            </div>
            <div class="item form-group">
                <div class="col-md-6 col-sm-6 offset-md-3">
                    <input type="submit" name="submit_tambah" class="btn btn-primary" value="Simpan">
                    <a href="index.php?page=tampil_dosen" class="btn btn-warning">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</body>

</html>
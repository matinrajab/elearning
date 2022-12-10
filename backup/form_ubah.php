<?php
    include 'config/konek.php';

    if(isset($_GET['nrp'])){
        $nrp = $_GET['nrp'];

        $sql = "SELECT * FROM mahasiswa WHERE nrp='$nrp'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) == 0){
            echo '<div class="alert alert-warning">'.$nrp.' tidak ada dalam database.</div>';
            exit();
        }else{
            $row = mysqli_fetch_assoc($result);
        }
    }

    if(isset($_POST['submit_ubah'])){
        $nrp = $_POST["nrp"];
        $nama = $_POST["nama"];
        $jenis_kelamin = $_POST["jenis_kelamin"];
        $agama = $_POST["agama"];
        $umur = $_POST["umur"];
        $alamat = $_POST["alamat"];
        $foto_name = $_FILES['foto']['name'];
        $foto_tmp = $_FILES['foto']['tmp_name'];
        $foto_size = $_FILES['foto']['size'];
        $error = $_FILES['foto']['error'];

        //cek apakah tidak mengganti gambar
        if($error !== 4){ //jika error != 4 berarti ada file yg diupload
            //cek apakah yang diupload adalah gambar
            $ekstensiGambarValid = ['jpg', 'jpeg', 'png']; //ekstensi yang valid
            $ekstensiGambar = explode('.', $foto_name); //pecah string dan simpan ke dalam array
            $ekstensiGambar = strtolower(end($ekstensiGambar)); //ambil index terakhir array
            //cek apakah ekstensi valid
            if(!in_array($ekstensiGambar, $ekstensiGambarValid)){
                echo "<script>
                        alert('yang anda upload bukan gambar!');
                        document.location='index.php?page=tampil_data';
                    </script>";
                exit;
            }
        }

        //cek jika ukurannya terlalu besar (lebih dari 3 mb)
        if($foto_size > 3000000){
            echo "<script>
                    alert('ukuran gambar terlalu besar!');
                    document.location='index.php?page=tampil_data';
                </script>";
            exit;
        }

        // lolos pengecekan, gambar siap diupload
        //generate nama gambar baru
        $foto_new_name = uniqid();
        $foto_new_name .= '.';
        $foto_new_name .= $ekstensiGambar;
        move_uploaded_file($foto_tmp, 'image/' . $foto_new_name);

        //cek apakah tidak mengganti gambar
        if($error === 4){ //jika error = 4 berarti tidak ada file yg diupload
            $sql = "UPDATE mahasiswa SET nrp='$nrp', nama='$nama', jenis_kelamin='$jenis_kelamin', agama='$agama', umur='$umur', alamat='$alamat' WHERE nrp='$nrp'";
        }else{ 
            // jika gambar diupdate, hapus gambar yg lama pada folder image
            unlink("image/".$row['foto']);
            
            $sql = "UPDATE mahasiswa SET foto='$foto_new_name', nrp='$nrp', nama='$nama', jenis_kelamin='$jenis_kelamin', agama='$agama', umur='$umur', alamat='$alamat' WHERE nrp='$nrp'";
        }
        if(mysqli_query($conn, $sql)){
            echo "<script>alert('Data $nrp berhasil diperbarui');
            document.location='index.php?page=tampil_data'; </script>";
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
		<center><font size="6">Edit Data Mahasiswa</font></center>
		<hr>
		<form action="" method="post" enctype="multipart/form-data">
			<div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">NRP</label>
                <div class="col-md-6 col-sm-6">
                    <input type="number" name="nrp" class="form-control" value="<?php echo $row['nrp']; ?>" autocomplete="off" required>
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">Nama Mahasiswa</label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="nama" class="form-control" value="<?php echo $row['nama']; ?>" autocomplete="off" required>
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">Jenis Kelamin</label>
                <div class="col-md-6 col-sm-6">
                    <select name="jenis_kelamin" class="form-control" required>
                        <option value="Laki-laki" <?php if($row['jenis_kelamin'] == 'Laki-laki'){ echo 'selected'; } ?>>Laki-laki</option>
                        <option value="Perempuan" <?php if($row['jenis_kelamin'] == 'Perempuan'){ echo 'selected'; } ?>>Perempuan</option>
                    </select>
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">Agama</label>
                <div class="col-md-6 col-sm-6">
                    <select name="agama" class="form-control" required>
                        <option value="Islam" <?php if($row['agama'] == 'Islam'){ echo 'selected'; } ?>>Islam</option>
                        <option value="Kristen" <?php if($row['agama'] == 'Kristen'){ echo 'selected'; } ?>>Kristen</option>
                        <option value="Hindu" <?php if($row['agama'] == 'Hindu'){ echo 'selected'; } ?>>Hindu</option>
                        <option value="Buddha" <?php if($row['agama'] == 'Buddha'){ echo 'selected'; } ?>>Buddha</option>
                        <option value="Katolik" <?php if($row['agama'] == 'Katolik'){ echo 'selected'; } ?>>Katolik</option>
                        <option value="Custom" <?php if($row['agama'] == 'Custom'){ echo 'selected'; } ?>>Custom</option>
                    </select>
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">Umur</label>
                <div class="col-md-6 col-sm-6">
                    <input type="number" name="umur" class="form-control" value="<?php echo $row['umur']; ?>" autocomplete="off" required>
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">Alamat</label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="alamat" class="form-control" value="<?php echo $row['alamat']; ?>" autocomplete="off" required>
                </div>
            </div>
            <div class="item">
                <label class="col-form-label col-md-3 col-sm-3 label-align">Foto</label>
                <div class="col-md-6 col-sm-6">
                    <img src="image/<?php echo $row['foto']; ?>" style="width: 120px;float: left;margin-bottom: 5px;">
                    <input type="file" name="foto">
                    <i><br>Abaikan jika tidak merubah foto</i>
                </div>
            </div>
            <div class="item form-group">
                <div class="col-md-6 col-sm-6 offset-md-3">
                    <input type="submit" name="submit_ubah" class="btn btn-primary" value="Simpan">
                    <a href="index.php?page=tampil_data" class="btn btn-warning">Kembali</a>
                </div>
            </div>
		</form>
	</div>
</body>

</html>
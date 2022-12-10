<?php
    include 'config/konek.php';
    
    if(isset($_POST["submit_tambah"])){
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

        //cek apakah tidak ada gambar yang diupload
        if($error === 4){ //jika error = 4 berarti tidak ada file yg diupload
            echo "<script>
                    alert('pilih gambar terlebih dahulu!');
                    document.location='index.php?page=form_tambah';
                </script>";
            exit;
        }else{
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

        $sql = "INSERT INTO mahasiswa
        VALUES ('$nrp', '$nama', '$jenis_kelamin', '$agama', '$umur', '$alamat', '$foto_new_name')";
        if(mysqli_query($conn, $sql)){
            echo "<script>alert('Data berhasil ditambahkan');
            document.location='index.php?page=tampil_data';</script>";
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
            <font size="6">Tambah Data Mahasiswa</font>
        </center>
        <hr>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">NRP</label>
                <div class="col-md-6 col-sm-6 ">
                    <input type="number" name="nrp" class="form-control" autocomplete="off" required>
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">Nama Mahasiswa</label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="nama" class="form-control" autocomplete="off" required>
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
                <label class="col-form-label col-md-3 col-sm-3 label-align">Agama</label>
                <div class="col-md-6 col-sm-6">
                    <select name="agama" class="form-control" required>
                        <option value="Islam">Islam</option>
                        <option value="Kristen">Kristen</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Buddha">Buddha</option>
                        <option value="Katolik">Katolik</option>
                        <option value="Custom">Custom</option>
                    </select>
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">Umur</label>
                <div class="col-md-6 col-sm-6">
                    <input type="number" name="umur" class="form-control" autocomplete="off" required>
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">Alamat</label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="alamat" class="form-control" autocomplete="off" required>
                </div>
            </div>
            <div class="item">
                <label class="col-form-label col-md-3 col-sm-3 label-align">Foto</label>
                <div class="col-md-6 col-sm-6">
                    <input type="file" name="foto" required>
                </div>
            </div>
            <div class="item form-group">
                <div class="col-md-6 col-sm-6 offset-md-3">
                    <input type="submit" name="submit_tambah" class="btn btn-primary" value="Simpan">
                    <a href="index.php?page=tampil_data" class="btn btn-warning">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</body>

</html>
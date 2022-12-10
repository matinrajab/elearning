<?php
    include '../config/konek.php';
    
    if(isset($_POST["submit_tambah"])){
        $judul = $_POST["judul"];
        $deskripsi = $_POST["deskripsi"];
        $deadline = $_POST["deadline"];

        //ambil nama dosen dari cookie
        $nama = str_replace('%20', ' ', $_COOKIE['name']);

        $sql_dosen = "SELECT * FROM dosen
                      WHERE nama = '$nama'";
        $result_dosen = mysqli_query($conn, $sql_dosen);
        $row_dosen = mysqli_fetch_assoc($result_dosen);
        
        //ambil matkul dari database dosen
        $matkul = $row_dosen['matkul'];

        $file_name = $_FILES['file_dosen']['name'];
        $file_tmp = $_FILES['file_dosen']['tmp_name'];
        $file_size = $_FILES['file_dosen']['size'];
        $error = $_FILES['file_dosen']['error'];

        //cek apakah tidak ada file yang diupload
        if($error === 4){ //jika error = 4 berarti tidak ada file yg diupload
            echo "<script>
                    alert('pilih file terlebih dahulu!');
                    document.location='index.php?page=list_tugas';
                </script>";
            exit;
        }

        // upload file
        move_uploaded_file($file_tmp, '../file_tugas/' . $file_name);

        //menambahkan data tugas ke database
        $sql_tugas = "INSERT INTO list_tugas (matkul, judul, deskripsi, deadline, file_dosen)
        VALUES ('$matkul', '$judul', '$deskripsi', '$deadline', '$file_name')";
        if(mysqli_query($conn, $sql_tugas)){
            echo '<script>alert("Tugas berhasil ditambahkan");
            document.location="index.php?page=list_tugas";</script>';
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
    <title>Upload Tugas</title>
</head>

<body class="bg-light">
    <div class="container" style="margin-top:20px">
        <center>
            <font size="6">Upload Tugas</font>
        </center>
        <hr>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">Judul</label>
                <div class="col-md-6 col-sm-6 ">
                    <input type="text" name="judul" class="form-control" autocomplete="off" required>
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">Deskripsi</label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="deskripsi" class="form-control" autocomplete="off" required>
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">Deadline</label>
                <div class="col-md-6 col-sm-6">
                    <input type="datetime-local" name="deadline" class="form-control" autocomplete="off" required>
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align">File</label>
                <div class="col-md-6 col-sm-6">
                    <input type="file" name="file_dosen" required>
                </div>
            </div>
            <div class="item form-group">
                <div class="col-md-6 col-sm-6 offset-md-3">
                    <input type="submit" name="submit_tambah" class="btn btn-primary" value="Simpan">
                    <a href="index.php" class="btn btn-warning">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</body>

</html>
<?php
    include 'config/konek.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        th {
            text-align: center;
        }
    </style>
    <title>Data Mahasiswa</title>
</head>

<body class="bg-light">
    <div class="container-fluid" style="margin-top:20px">
        <center>
            <font size="6">Data Mahasiswa D4 IT B</font>
        </center>
        <hr>
        <a href="index.php?page=form_tambah"><button class="btn btn-dark right">Tambah Data</button></a>
        <div class="table-responsive">
            <table class="table table-striped jambo_table bulk_action">
                <thead>
                    <tr>
                        <th>NO.</th>
                        <th>Foto</th>
                        <th>NRP</th>
                        <th>Nama Mahasiswa</th>
                        <th>Jenis Kelamin</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //query ke database SELECT tabel mahasiswa urut berdasarkan nrp terkecil
                    $sql = "SELECT * FROM mahasiswa ORDER BY nrp ASC";
                    $result = mysqli_query($conn, $sql);
                    //jika query diatas menghasilkan nilai > 0 maka menjalankan script di bawah if
                    if(mysqli_num_rows($result) > 0){
                        //membuat variabel $no untuk menyimpan nomor urut
                        $no = 1;
                        //melakukan perulangan while dengan dari dari query $sql
                        while($row = mysqli_fetch_assoc($result)){
                            //menampilkan data perulangan
                            echo '
                            <tr>
                                <td>'.$no.'</td>
                                <td style="text-align: center;"><img src="image/'.$row['foto'].'" style="width: 60px;"></td>
                                <td>'.$row['nrp'].'</td>
                                <td>'.$row['nama'].'</td>
                                <td>'.$row['jenis_kelamin'].'</td>
                                <td>
                                    <a href="index.php?page=form_ubah&nrp='.$row['nrp'].'" class="btn btn-secondary btn-sm">Edit</a>
                                    <a href="index.php?page=hapus&nrp='.$row['nrp'].'" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin ingin menghapus data '.$row['nrp'].'?\')">Delete</a>
                                </td>
                            </tr>
                            ';
                            $no++;
                        }
                    //jika query menghasilkan nilai 0
                    }else{
                        echo '
                        <tr>
                            <td colspan="6">Tidak ada data.</td>
                        </tr>
                        ';
                    }
                    ?>
                <tbody>
            </table>
        </div>
    </div>
</body>

</html>
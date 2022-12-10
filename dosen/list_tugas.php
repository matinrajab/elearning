<?php
    include '../config/konek.php';
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
            <font size="6">Daftar Tugas D4 IT B</font>
        </center>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped jambo_table bulk_action">
                <thead>
                    <tr>
                        <th>NO.</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Deadline</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //ambil nama dosen dari cookie
                    $nama = str_replace('%20', ' ', $_COOKIE['name']);

                    $sql_dosen = "SELECT * FROM dosen
                                WHERE nama = '$nama'";
                    $result_dosen = mysqli_query($conn, $sql_dosen);
                    $row_dosen = mysqli_fetch_assoc($result_dosen);
                    
                    //ambil matkul dari database dosen
                    $matkul = $row_dosen['matkul'];

                    //query ke database SELECT tabel tugas urut berdasarkan id_tugas terkecil
                    $sql = "SELECT * FROM list_tugas WHERE matkul='$matkul' ORDER BY id_tugas ASC";
                    $result = mysqli_query($conn, $sql);
                    //jika jumlah data yg didapat > 0 maka menjalankan script di bawah if
                    if(mysqli_num_rows($result) > 0){
                        //membuat variabel $no untuk menyimpan nomor urut
                        $no = 1;
                        //melakukan perulangan while dengan dari dari query $sql
                        while($row = mysqli_fetch_assoc($result)){
                            //menampilkan data perulangan
                            echo '
                            <tr>
                                <td>'.$no.'</td>
                                <td>'.$row['judul'].'</td>
                                <td>'.$row['deskripsi'].'</td>
                                <td>'.$row['deadline'].'</td>
                                <td>
                                    <a href="index.php?page=pengumpulan&id_tugas='.$row['id_tugas'].'" class="btn btn-secondary btn-sm">Lihat Pengumpulan</a>
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
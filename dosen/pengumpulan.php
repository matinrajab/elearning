<?php
    session_start();

    include '../config/konek.php';

    if(isset($_GET['id_tugas'])){
        $id_tugas = $_GET['id_tugas'];

        // buat session id tugas
		$_SESSION['id_tugas'] = $id_tugas;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .mid {
            text-align: center;
        }
    </style>
    <title>Data Mahasiswa</title>
</head>

<body class="bg-light">
    <div class="container-fluid" style="margin-top:20px">
        <center>
            <font size="6">Daftar Pengumpulan Tugas</font>
        </center>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped jambo_table bulk_action">
                <thead>
                    <tr>
                        <th>NO.</th>
                        <th>NRP</th>
                        <th>Nama Mahasiswa</th>
                        <th class="mid">Nilai</th>
                        <th class="mid">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //query ke database SELECT tabel mahasiswa urut berdasarkan nrp terkecil
                    $sql_mhs = "SELECT * FROM mahasiswa ORDER BY nrp ASC";
                    $result_mhs = mysqli_query($conn, $sql_mhs);
                    //jika query diatas menghasilkan nilai > 0 maka menjalankan script di bawah if
                    if(mysqli_num_rows($result_mhs) > 0){
                        //membuat variabel $no untuk menyimpan nomor urut
                        $no = 1;
                        //melakukan perulangan while dengan dari dari query $sql_mhs
                        while($row_mhs = mysqli_fetch_assoc($result_mhs)){
                            $nrp = $row_mhs['nrp'];
                            //ambil data dari tabel tugas_mhs
                            $sql_tugas = "SELECT * FROM tugas_mhs WHERE id_tugas=$id_tugas AND nrp='$nrp'";
                            $result_tugas = mysqli_query($conn, $sql_tugas);
                            //jika query menghasilkan nilai > 0 maka ambil data nilainya
                            if(mysqli_num_rows($result_tugas) > 0){
                                $row_tugas = mysqli_fetch_assoc($result_tugas);
                                $nilai = $row_tugas['nilai'];
                                $file_mhs = $row_tugas['file_mhs'];
                            }else{ //jika data tidak ada, atur nilai menjadi NULL
                                $nilai = NULL;
                                $file_mhs = NULL;
                            }
                            //menampilkan data perulangan
                            echo '
                            <tr>
                                <td>'.$no.'</td>
                                <td>'.$row_mhs['nrp'].'</td>
                                <td>'.$row_mhs['nama'].'</td>
                                <td class="mid">'.$nilai.'</td>
                                <td class="mid">' ?>
                                    <?php
                                    if($file_mhs != NULL){
                                        echo '
                                        <a href="../download.php?file='?><?php echo $file_mhs; ?> <?php echo '" class="btn btn-secondary btn-sm">Download</a>
                                        <a href="index.php?page=penilaian&nrp='.$row_mhs['nrp'].'" class="btn btn-success btn-sm">Beri Nilai</a>';
                                    }
                                    ?>
                                <?php echo '
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
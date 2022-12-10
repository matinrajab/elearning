<?php
    include '../config/konek.php';

    if(isset($_GET['matkul'])){
        $matkul = $_GET['matkul'];

        // buat session matkul
		$_SESSION['matkul'] = $matkul;
    }

    //ambil nama mhs dari cookie
    $nama = str_replace('%20', ' ', $_COOKIE['name']);
    $sql_mhs = "SELECT * FROM mahasiswa
                  WHERE nama = '$nama'";
    $result_mhs = mysqli_query($conn, $sql_mhs);
    $row_mhs = mysqli_fetch_assoc($result_mhs);
    //ambil nrp dari database mahasiswa
    $nrp = $row_mhs['nrp'];
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
            <font size="6">Daftar Tugas <?php echo $matkul; ?></font>
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
                        <th class="mid">Nilai</th>
                        <th class="mid">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //query ke database SELECT tabel tugas urut berdasarkan id_tugas terkecil
                    $sql_list_tugas = "SELECT * FROM list_tugas WHERE matkul='$matkul' ORDER BY id_tugas ASC";
                    $result_list_tugas = mysqli_query($conn, $sql_list_tugas);
                    //jika jumlah data yg didapat > 0 maka menjalankan script di bawah if
                    if(mysqli_num_rows($result_list_tugas) > 0){
                        //membuat variabel $no untuk menyimpan nomor urut
                        $no = 1;
                        //melakukan perulangan while dengan dari dari query $sql_list_tugas
                        while($row_list_tugas = mysqli_fetch_assoc($result_list_tugas)){
                            $id_tugas = $row_list_tugas['id_tugas']; 
                            $file_dosen = $row_list_tugas['file_dosen']; 
                            $id_tugas = $row_list_tugas['id_tugas']; 
                            //ambil data dari tabel tugas_mhs
                            $sql_tugas = "SELECT * FROM tugas_mhs WHERE id_tugas=$id_tugas AND nrp='$nrp'";
                            $result_tugas = mysqli_query($conn, $sql_tugas);
                            //jika query menghasilkan nilai > 0 maka ambil data nilainya
                            if(mysqli_num_rows($result_tugas) > 0){
                                $row_tugas = mysqli_fetch_assoc($result_tugas);
                                $nilai = $row_tugas['nilai'];
                            }else{ //jika data tidak ada, atur nilai menjadi NULL
                                $nilai = NULL;
                            }
                            //menampilkan data perulangan
                            echo '
                            <tr>
                                <td>'.$no.'</td>
                                <td>'.$row_list_tugas['judul'].'</td>
                                <td>'.$row_list_tugas['deskripsi'].'</td>
                                <td>'.$row_list_tugas['deadline'].'</td>
                                <td class="mid">'.$nilai.'</td>
                                <td class="mid">
                                    <a href="../download.php?file='?><?php echo $file_dosen; ?> <?php echo '" class="btn btn-secondary btn-sm">Download</a>
                                    <a href="index.php?page=upload_tugas&id_tugas='.$id_tugas.'" class="btn btn-primary btn-sm">Submit</a>
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
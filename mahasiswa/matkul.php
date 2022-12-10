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
        .mid {
            text-align: center;
        }
    </style>
    <title>Data Mahasiswa</title>
</head>

<body class="bg-light">
    <div class="container-fluid" style="margin-top:20px">
        <center>
            <font size="6">Mata Kuliah D4 IT B</font>
        </center>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped jambo_table bulk_action">
                <thead>
                    <tr>
                        <th>NO.</th>
                        <th>Mata Kuliah</th>
                        <th>NIP</th>
                        <th>Dosen</th>
                        <th class="mid">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //query ke database SELECT tabel dosen urut berdasarkan nip terkecil
                    $sql = "SELECT * FROM dosen ORDER BY nip ASC";
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
                                <td>'.$row['matkul'].'</td>
                                <td>'.$row['nip'].'</td>
                                <td>'.$row['nama'].'</td>
                                <td class="mid">
                                    <a href="index.php?page=list_tugas&matkul='.$row['matkul'].'" class="btn btn-secondary btn-sm">Lihat Tugas</a>
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
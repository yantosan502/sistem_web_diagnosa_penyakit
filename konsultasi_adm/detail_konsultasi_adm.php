<!-- menampilkan data hasil konsultasi -->
<?php
// mengambil id dari parameter
$idkonsultasi = $_GET['id'];

$sql = "SELECT * FROM konsultasi WHERE idkonsultasi='$idkonsultasi'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!-- Tampilan halaman detail konsultasi -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
    <div class="row">
        <div class="col-sm-12">
            <form action="" method="POST">
                <div class="card border-dark">
                    <div class="card">
                        <div class="card-header bg-primary text-white border-dark mt-5"><strong>Hasil Konsultasi</strong></div>
                        <div class="card-body">

                            <div class="form-group">
                                <label for="">Nama Pasien</label>
                                <input type="text" class="form-control" value="<?php echo $row['nama']; ?>" name="nama" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Umur Pasien</label>
                                <input type="text" class="form-control" value="<?php echo $row['umur']; ?>" name="umur" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Berat Badan</label>
                                <input type="text" class="form-control" value="<?php echo $row['b_badan']; ?>" name="b_badan" readonly>
                            </div>
                            <div class="form-group">
                                <label for="">Tinggi Badan</label>
                                <input type="text" class="form-control" value="<?php echo $row['t_badan']; ?>" name="t_badan" readonly>
                            </div>

                            <!-- Tabel gejala-gejala -->
                            <label for="">Gejala-gejala Penyakit Yang Dipilih</label>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="40px">No</th>
                                        <th width="700px">Nama Gejala</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $sql = "SELECT detail_konsultasi.idkonsultasi,detail_konsultasi.idgejala,gejala.nmgejala
                                            FROM detail_konsultasi INNER JOIN gejala 
                                            ON detail_konsultasi.idgejala=gejala.idgejala WHERE idkonsultasi='$idkonsultasi'";
                                    $result = $conn->query($sql);
                                    while ($row = $result->fetch_assoc()) {
                                    ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $row['nmgejala']; ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>

                            <!-- Hasil konsultasi penyakitnya -->
                            <label for="">Hasil Konsultasi Penyakit:</label>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="40px">No</th>
                                        <th width="150px">Nama Penyakit</th>
                                        <th width="100px">Persentase</th>
                                        <th width="700px">Solusi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $sql = "SELECT detail_penyakit.idkonsultasi,detail_penyakit.idpenyakit,penyakit.nmpenyakit,
                                                    penyakit.solusi,detail_penyakit.persentase 
                                            FROM detail_penyakit INNER JOIN penyakit 
                                            ON detail_penyakit.idpenyakit=penyakit.idpenyakit WHERE idkonsultasi='$idkonsultasi'
                                            ORDER BY persentase DESC";
                                    $result = $conn->query($sql);
                                    while ($row = $result->fetch_assoc()) {
                                    ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $row['nmpenyakit']; ?></td>
                                            <td><?php echo $row['persentase'] . "%"; ?></td>
                                            <td><?php echo $row['solusi']; ?></td>
                                        </tr>
                                    <?php
                                    }
                                    $conn->close();
                                    ?>
                                </tbody>
                            </table>
                            <a class="btn btn-danger" href="?page=konsultasiadm">Kembali</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
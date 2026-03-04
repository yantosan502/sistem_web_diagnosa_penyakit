<!-- Proses menampilkan data hasil konsultasi -->
<?php
// mengambil id dari parameter
$idkonsultasi = $_GET['idkonsultasi'];

$sql = "SELECT * FROM konsultasi WHERE idkonsultasi='$idkonsultasi'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

// fungsi kategorisasi & format
function kategorikan_usia($umur) {
    if ($umur >= 0 && $umur <= 6) {
        return "Bayi (0-6 bulan)";
    } elseif ($umur >= 7 && $umur <= 23) {
        return "Baduta (7-23 bulan)";
    } else {
        return "Balita (24-59 bulan)";
    }
}

function format_usia($umur) {
    $tahun = floor($umur / 12);
    $bulan = $umur % 12;
    
    if ($tahun == 0) {
        return "$bulan bulan";
    } elseif ($bulan == 0) {
        return "$tahun tahun";
    } else {
        return "$tahun tahun $bulan bulan";
    }
}

$umur = (int)$row['umur']; // Konversi ke integer
$kategori_usia = kategorikan_usia($umur);
$usia_format = format_usia($umur);
?>

<!-- Tampilan hasil konsultasi -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Konsultasi</title>
</head>
<body>
    <div class="row">
        <div class="col-sm-12">
            <form action="" method="POST">
                <div class="card border-dark">
                    <div class="card">
                        <div class="card-header bg-primary text-white border-dark"><strong>Hasil Konsultasi</strong></div>
                        <div class="card-body">
                            <!-- Nama -->
                            <div class="form-group">
                                <label for="">Nama Pasien</label>
                                <input type="text" class="form-control" value="<?php echo $row['nama']; ?>" name="nama" readonly>
                            </div>
                            <!-- Umur -->
                            <div class="form-group">
                                <label for="">Umur</label>
                                <!-- <input type="text" class="form-control" value="<?php echo $row['umur']; ?>" name="umur" readonly> -->
                                <input type="text" class="form-control" value="<?php echo $usia_format . ' (' . $umur . ' bulan)'; ?>" name="umur" readonly>
                            </div>
                            <!-- Kategori Usia -->
                            <div class="form-group">
                                <label for="">Kategori Usia</label>
                                <input type="text" class="form-control" value="<?php echo $kategori_usia; ?>" readonly>
                            </div>
                            <!-- Berat Badan -->
                            <div class="form-group">
                                <label for="">Berat Badan (KG)</label>
                                <input type="text" class="form-control" value="<?php echo $row['b_badan']; ?>" name="b_badan" readonly>
                            </div>
                            <!-- Tinggi Badan -->
                            <div class="form-group">
                                <label for="">Tinggi Badan (CM)</label>
                                <input type="text" class="form-control" value="<?php echo $row['t_badan']; ?>" name="t_badan" readonly>
                            </div>

                            <!-- Tabel gejala-gejala -->
                            <label for="">Gejala-gejala Penyakit Yang Dipilih:</label>
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

                            <!-- hasil konsultasi penyakitnya -->
                            <label for="">Hasil Konsultasi Penyakit:</label>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="40px">No</th>
                                        <th width="150px">Nama Penyakit</th>
                                        <th width="100px">Persentase</th>
                                        <th width="500px">Solusi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $penyakit_result = []; // Array untuk menyimpan hasil
                                    $sql = "SELECT detail_penyakit.idkonsultasi,detail_penyakit.idpenyakit,penyakit.nmpenyakit,
                                                penyakit.solusi,detail_penyakit.persentase 
                                            FROM detail_penyakit INNER JOIN penyakit 
                                            ON detail_penyakit.idpenyakit=penyakit.idpenyakit WHERE idkonsultasi='$idkonsultasi'
                                            ORDER BY persentase DESC";
                                    $result = $conn->query($sql);
                                    while ($row = $result->fetch_assoc()) {
                                        $penyakit_result[] = $row; // Simpan ke array
                                    ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $row['nmpenyakit']; ?></td>
                                            <td><?php echo $row['persentase'] . "%"; ?></td>
                                            <td><?php echo $row['solusi']; ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            
                            <!-- INFORMASI HASIL DIAGNOSIS -->
                            <?php if (count($penyakit_result) > 0): ?>
                                <?php 
                                $topDisease = $penyakit_result[0]['nmpenyakit'];
                                $percentage = $penyakit_result[0]['persentase'];
                                ?>
                                
                                <div class="card mt-4 border-warning">
                                    <div class="card-header bg-warning text-dark">
                                        <strong>📋 INFORMASI HASIL DIAGNOSIS</strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-info" role="alert">
                                            <p class="mb-2">
                                                Berdasarkan gejala yang dilaporkan, sistem telah mengidentifikasi kemungkinan tertinggi adalah 
                                                <strong><?php echo $topDisease; ?></strong> dengan tingkat keyakinan 
                                                <strong><?php echo number_format($percentage, 1); ?>%</strong>. 
                                                Hasil ini diperoleh melalui metode <em>Forward Chaining</em> berdasarkan gejala-gejala yang dipilih.
                                            </p>
                                        </div>
                                        
                                        <div class="alert alert-danger" role="alert">
                                            <strong>⚠️ PENTING:</strong> 
                                            <strong>HASIL DIAGNOSIS SISTEM INI BERSIFAT SKRINING AWAL DAN BUKAN DIAGNOSIS MEDIS FINAL.</strong>
                                        </div>
                                        
                                        <div class="alert alert-primary" role="alert">
                                            <p class="mb-0">
                                                Sangat direkomendasikan untuk melakukan pemeriksaan lebih lanjut dengan 
                                                <strong>dokter spesialis anak atau ahli gizi</strong> untuk konfirmasi diagnosis yang akurat 
                                                dan mendapatkan penanganan yang tepat sesuai kondisi anak.
                                            </p>
                                        </div>
                                        
                                        <div class="alert alert-warning" role="alert">
                                            <strong>📌 PERHATIAN:</strong> 
                                            Jangan tunda pemeriksaan medis jika anak menunjukkan tanda-tanda stunting atau gangguan 
                                            pertumbuhan lainnya. Deteksi dini dan penanganan cepat adalah kunci keberhasilan pemulihan.
                                        </div>
                                        
                                        <div class="alert alert-secondary mb-0" role="alert">
                                            <small>
                                                <strong>Kontak Bantuan:</strong><br>
                                                • Puskesmas terdekat<br>
                                                • Hotline Stunting: 119 ext 9<br>
                                                • Ambulans Darurat: 118 / 119
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                        </div>
                        <!-- Tombol cetak pdf -->
                        <div class="card-footer">
                            <a href="cetak_hasil.php?idkonsultasi=<?php echo $idkonsultasi; ?>" class="btn btn-primary">Download PDF</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php $conn->close(); ?>

</body>
</html>

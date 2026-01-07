<?php
// konsultasi_adm/detail_konsultasi_adm.php

// Pastikan koneksi database tersedia
if (!isset($koneksi)) {
    die("Error: Koneksi database tidak tersedia");
}

// Ambil parameter ID dari URL - cek kedua kemungkinan
$from = isset($_GET['from']) ? $_GET['from'] : 'konsultasiadm';
$back_url = ($from == 'dashboard') ? '?page=dashboard' : '?page=konsultasiadm';
$back_text = ($from == 'dashboard') ? 'Kembali ke Dashboard' : 'Kembali ke Daftar Konsultasi';

$idkonsultasi = 0;
if (isset($_GET['idkonsultasi'])) {
    $idkonsultasi = (int)$_GET['idkonsultasi'];
} elseif (isset($_GET['id'])) {
    $idkonsultasi = (int)$_GET['id'];
}

if ($idkonsultasi == 0) {
    echo '<div class="alert alert-danger mt-5">
            <h4>Error!</h4>
            <p>ID Konsultasi tidak valid.</p>
            <p>Debug: idkonsultasi = ' . (isset($_GET['idkonsultasi']) ? $_GET['idkonsultasi'] : 'tidak ada') . '</p>
            <p>Debug: id = ' . (isset($_GET['id']) ? $_GET['id'] : 'tidak ada') . '</p>
            <a href="?page=konsultasiadm" class="btn btn-primary">Kembali ke Daftar Konsultasi</a>
          </div>';
    exit;
}

// Query untuk mengambil data konsultasi
$query_konsultasi = "SELECT * FROM konsultasi WHERE idkonsultasi = $idkonsultasi";
$result_konsultasi = mysqli_query($koneksi, $query_konsultasi);

if (!$result_konsultasi || mysqli_num_rows($result_konsultasi) == 0) {
    echo '<div class="alert alert-danger mt-5">
            <h4>Data Tidak Ditemukan!</h4>
            <p>Konsultasi dengan ID tersebut tidak ditemukan.</p>
            <a href="?page=konsultasiadm" class="btn btn-primary">Kembali ke Daftar Konsultasi</a>
          </div>';
    exit;
}

$data_konsultasi = mysqli_fetch_assoc($result_konsultasi);

// Query untuk mengambil gejala yang dipilih
$query_gejala = "SELECT g.nmgejala 
                 FROM detail_konsultasi dk 
                 JOIN gejala g ON dk.idgejala = g.idgejala 
                 WHERE dk.idkonsultasi = $idkonsultasi 
                 ORDER BY g.nmgejala ASC";
$result_gejala = mysqli_query($koneksi, $query_gejala);

// Query untuk mengambil hasil diagnosa
$query_diagnosa = "SELECT p.nmpenyakit, p.keterangan, p.solusi, dp.persentase 
                   FROM detail_penyakit dp 
                   JOIN penyakit p ON dp.idpenyakit = p.idpenyakit 
                   WHERE dp.idkonsultasi = $idkonsultasi 
                   ORDER BY dp.persentase DESC";
$result_diagnosa = mysqli_query($koneksi, $query_diagnosa);
?>

<div class="row mt-5">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4><i class="fas fa-eye mr-2"></i>Detail Hasil Konsultasi</h4>
                <a href="<?php echo $back_url; ?>" class="btn btn-light btn-sm">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                
                <!-- Informasi Pasien -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-header">
                                <h5><i class="fas fa-user mr-2"></i>Informasi Pasien</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>ID Konsultasi</strong></td>
                                        <td>: <?php echo $data_konsultasi['idkonsultasi']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Nama Pasien</strong></td>
                                        <td>: <?php echo htmlspecialchars($data_konsultasi['nama']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tanggal Konsultasi</strong></td>
                                        <td>: <?php echo date('d F Y', strtotime($data_konsultasi['tanggal'])); ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-header">
                                <h5><i class="fas fa-info-circle mr-2"></i>Status Konsultasi</h5>
                            </div>
                            <div class="card-body">
                                <div class="text-center">
                                    <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
                                    <h5 class="text-success mt-2">Konsultasi Selesai</h5>
                                    <p class="text-muted">Diagnosa telah diberikan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gejala yang Dipilih -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5><i class="fas fa-list-ul mr-2"></i>Gejala-gejala yang Dipilih</h5>
                            </div>
                            <div class="card-body">
                                <?php if ($result_gejala && mysqli_num_rows($result_gejala) > 0): ?>
                                    <div class="row">
                                        <?php 
                                        $no = 1;
                                        while($gejala = mysqli_fetch_assoc($result_gejala)): 
                                        ?>
                                        <div class="col-md-6 mb-2">
                                            <div class="alert alert-info py-2">
                                                <i class="fas fa-check mr-2"></i>
                                                <?php echo $no++; ?>. <?php echo htmlspecialchars($gejala['nmgejala']); ?>
                                            </div>
                                        </div>
                                        <?php endwhile; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle mr-2"></i>
                                        Tidak ada data gejala yang dipilih.
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hasil Diagnosa -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5><i class="fas fa-stethoscope mr-2"></i>Hasil Diagnosa Penyakit</h5>
                            </div>
                            <div class="card-body">
                                <?php if ($result_diagnosa && mysqli_num_rows($result_diagnosa) > 0): ?>
                                    <?php 
                                    $no = 1;
                                    while($diagnosa = mysqli_fetch_assoc($result_diagnosa)): 
                                    ?>
                                    <div class="card mb-3 <?php echo $no == 1 ? 'border-success' : 'border-secondary'; ?>">
                                        <div class="card-header <?php echo $no == 1 ? 'bg-success text-white' : 'bg-light'; ?>">
                                            <h6 class="mb-0">
                                                <?php if($no == 1): ?>
                                                    <i class="fas fa-trophy mr-2"></i>Diagnosa Utama:
                                                <?php else: ?>
                                                    <i class="fas fa-list mr-2"></i>Kemungkinan Lain:
                                                <?php endif; ?>
                                                <?php echo htmlspecialchars($diagnosa['nmpenyakit']); ?>
                                                <span class="badge badge-<?php echo $no == 1 ? 'light' : 'primary'; ?> ml-2">
                                                    <?php echo $diagnosa['persentase']; ?>%
                                                </span>
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6><i class="fas fa-info-circle text-info mr-2"></i>Keterangan:</h6>
                                                    <p><?php echo htmlspecialchars($diagnosa['keterangan']); ?></p>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6><i class="fas fa-medkit text-success mr-2"></i>Solusi/Pengobatan:</h6>
                                                    <p><?php echo htmlspecialchars($diagnosa['solusi']); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php 
                                    $no++;
                                    endwhile; 
                                    ?>
                                <?php else: ?>
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle mr-2"></i>
                                        Tidak ada hasil diagnosa yang ditemukan.
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="row mt-4">
                    <div class="col-12 text-center">
                        <a href="<?php echo $back_url; ?>" class="btn btn-primary">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                        <button onclick="window.print()" class="btn btn-secondary ml-2">
                            <i class="fas fa-print mr-2"></i>Print Hasil
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- CSS untuk Print -->
<style>
@media print {
    .btn, .card-header .btn {
        display: none !important;
    }
    .navbar, .breadcrumb {
        display: none !important;
    }
}
</style>

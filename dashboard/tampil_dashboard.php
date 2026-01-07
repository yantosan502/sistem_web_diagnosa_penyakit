<?php
// dashboard/tampil_dashboard.php

// Cek apakah user adalah Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != "Admin") {
    echo '<div class="alert alert-danger mt-5">
            <h4>Akses Ditolak!</h4>
            <p>Anda tidak memiliki hak akses untuk melihat dashboard.</p>
          </div>';
    exit;
}

// Debug info - hapus setelah berhasil
echo "<!-- Debug: Session Role = " . $_SESSION['role'] . " -->";

// Cek apakah koneksi sudah ada
if (!isset($koneksi) || !$koneksi) {
    echo '<div class="alert alert-danger mt-5">
            <h4>Error Database!</h4>
            <p>Koneksi database tidak tersedia. Pastikan:</p>
            <ul>
                <li>Database <strong>sistem_pakar_web</strong> sudah dibuat</li>
                <li>File config.php menggunakan nama database yang benar</li>
                <li>XAMPP MySQL sudah berjalan</li>
            </ul>
          </div>';
    exit;
}

// Test koneksi database
$test_query = mysqli_query($koneksi, "SELECT 1 as test");
if (!$test_query) {
    echo '<div class="alert alert-danger mt-5">
            <h4>Error Database!</h4>
            <p>Koneksi database gagal: ' . mysqli_error($koneksi) . '</p>
            <p>Current database: <strong>' . (isset($database) ? $database : 'Unknown') . '</strong></p>
          </div>';
    exit;
}

// Ambil data dengan cara yang lebih sederhana
$total_konsultasi = 0;
$total_penyakit = 0;
$total_gejala = 0;
$total_aturan = 0;

// Hitung total konsultasi
$result = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM konsultasi");
if ($result && $row = mysqli_fetch_assoc($result)) {
    $total_konsultasi = $row['total'];
}

// Hitung total penyakit
$result = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM penyakit");
if ($result && $row = mysqli_fetch_assoc($result)) {
    $total_penyakit = $row['total'];
}

// Hitung total gejala
$result = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM gejala");
if ($result && $row = mysqli_fetch_assoc($result)) {
    $total_gejala = $row['total'];
}

// Hitung total aturan
$result = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM basis_aturan");
if ($result && $row = mysqli_fetch_assoc($result)) {
    $total_aturan = $row['total'];
}
?>

<div class="row mt-5">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4><i class="fas fa-chart-pie mr-2"></i>Dashboard Analitik Konsultasi</h4>
                <small>Hanya Admin yang dapat mengakses halaman ini</small>
            </div>
            <div class="card-body">
                
                <!-- Test Alert -->
                <div class="alert alert-success">
                    <i class="fas fa-check-circle mr-2"></i>
                    Dashboard berhasil dimuat! Koneksi database OK.
                </div>

                <!-- Statistik Umum -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body text-center">
                                <i class="fas fa-users fa-3x mb-2"></i>
                                <h3><?php echo $total_konsultasi; ?></h3>
                                <p>Total Konsultasi</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body text-center">
                                <i class="fas fa-virus fa-3x mb-2"></i>
                                <h3><?php echo $total_penyakit; ?></h3>
                                <p>Total Penyakit</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body text-center">
                                <i class="fas fa-list-ul fa-3x mb-2"></i>
                                <h3><?php echo $total_gejala; ?></h3>
                                <p>Total Gejala</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-danger text-white">
                            <div class="card-body text-center">
                                <i class="fas fa-book-medical fa-3x mb-2"></i>
                                <h3><?php echo $total_aturan; ?></h3>
                                <p>Total Basis Aturan</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grafik Sederhana -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5><i class="fas fa-chart-pie mr-2"></i>Distribusi Penyakit</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="chartPenyakit" height="300"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5><i class="fas fa-table mr-2"></i>Data Konsultasi</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <td><strong>Total User yang Berkonsultasi</strong></td>
                                        <td class="text-center"><span class="badge badge-info"><?php echo $total_konsultasi; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Jenis Penyakit Terdata</strong></td>
                                        <td class="text-center"><span class="badge badge-success"><?php echo $total_penyakit; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Gejala Terdata</strong></td>
                                        <td class="text-center"><span class="badge badge-warning"><?php echo $total_gejala; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Basis Aturan Aktif</strong></td>
                                        <td class="text-center"><span class="badge badge-danger"><?php echo $total_aturan; ?></span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Konsultasi Terbaru -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5><i class="fas fa-list mr-2"></i>Data Konsultasi Terbaru</h5>
                            </div>
                            <div class="card-body">
                                <?php
                                $query_konsultasi = "SELECT * FROM konsultasi ORDER BY tanggal DESC LIMIT 10";
                                $result_konsultasi = mysqli_query($koneksi, $query_konsultasi);
                                
                                if ($result_konsultasi && mysqli_num_rows($result_konsultasi) > 0):
                                ?>
                                <div class="table-responsive">
                                    <table class="table table-striped" id="myTable">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Nama Pasien</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $no = 1;
                                            while($row = mysqli_fetch_assoc($result_konsultasi)):
                                            ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo date('d/m/Y', strtotime($row['tanggal'])); ?></td>
                                                <td><?php echo $row['nama']; ?></td>
                                                <td>
                                                    <a href="?page=konsultasiadm&action=detail&idkonsultasi=<?php echo $row['idkonsultasi']; ?>&from=dashboard" 
                                                        class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye mr-1"></i>Detail
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php else: ?>
                                <div class="text-center text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                    <p>Belum ada data konsultasi</p>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Chart.js untuk grafik -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Ambil data penyakit untuk grafik
<?php
$penyakit_labels = [];
$penyakit_data = [];
$colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'];

$query_chart = "SELECT p.nmpenyakit, COUNT(dp.idpenyakit) as jumlah 
                FROM detail_penyakit dp 
                JOIN penyakit p ON dp.idpenyakit = p.idpenyakit 
                GROUP BY dp.idpenyakit, p.nmpenyakit 
                ORDER BY jumlah DESC";
$result_chart = mysqli_query($koneksi, $query_chart);

if ($result_chart) {
    while($row = mysqli_fetch_assoc($result_chart)) {
        $penyakit_labels[] = $row['nmpenyakit'];
        $penyakit_data[] = (int)$row['jumlah'];
    }
}

// Jika tidak ada data, buat data dummy
if (empty($penyakit_data)) {
    $penyakit_labels = ['Belum ada data'];
    $penyakit_data = [1];
    $colors = ['#cccccc'];
}
?>

const ctx = document.getElementById('chartPenyakit').getContext('2d');
const chart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: <?php echo json_encode($penyakit_labels); ?>,
        datasets: [{
            data: <?php echo json_encode($penyakit_data); ?>,
            backgroundColor: <?php echo json_encode(array_slice($colors, 0, count($penyakit_labels))); ?>,
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        if (context.label === 'Belum ada data') {
                            return 'Belum ada data konsultasi';
                        }
                        let total = context.dataset.data.reduce((a, b) => a + b, 0);
                        let percentage = Math.round((context.raw / total) * 100);
                        return context.label + ': ' + context.raw + ' (' + percentage + '%)';
                    }
                }
            }
        }
    }
});
</script>

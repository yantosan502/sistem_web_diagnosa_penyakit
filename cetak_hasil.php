<?php
require 'vendor/autoload.php';
use Dompdf\Dompdf;
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "sistem_pakar_web");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
// Ambil ID konsultasi dari parameter
$idkonsultasi = $_GET['idkonsultasi'];
// Query hasil konsultasi
$sql = "SELECT * FROM konsultasi WHERE idkonsultasi='$idkonsultasi'";
$result = $conn->query($sql);
$konsultasi = $result->fetch_assoc();
// Ambil gejala-gejala yang dipilih
$gejala = [];
$sql = "SELECT gejala.nmgejala 
        FROM detail_konsultasi 
        INNER JOIN gejala ON detail_konsultasi.idgejala = gejala.idgejala 
        WHERE idkonsultasi='$idkonsultasi'";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $gejala[] = $row['nmgejala'];
}
// Ambil hasil penyakit
$penyakit = [];
$sql = "SELECT penyakit.nmpenyakit, detail_penyakit.persentase, penyakit.solusi 
        FROM detail_penyakit 
        INNER JOIN penyakit ON detail_penyakit.idpenyakit = penyakit.idpenyakit 
        WHERE idkonsultasi='$idkonsultasi'";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $penyakit[] = $row;
}

// Urutkan penyakit berdasarkan persentase tertinggi
usort($penyakit, function($a, $b) {
    return $b['persentase'] - $a['persentase'];
});

// Template HTML untuk PDF - dengan tampilan yang lebih baik
$html = '<style>
    body {
        font-family: "Helvetica", sans-serif;
        font-size: 12pt;
        line-height: 1.4;
        color: #333;
        margin: 0;
        padding: 0;
        height: 100%;
    }
    .container {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
    .header {
        text-align: center;
        margin-bottom: 20px;
        padding: 15px 0;
        border-bottom: 2px solid #4a7aff;
    }
    h1 {
        color: #4a7aff;
        margin: 0;
        font-size: 24pt;
        font-weight: bold;
    }
    .content {
        flex: 1;
    }
    .section {
        margin-bottom: 30px;
    }
    .two-columns {
        display: flex;
        margin-bottom: 20px;
    }
    .column {
        width: 48%;
        margin: 0 1%;
    }
    h2 {
        color: #4a7aff;
        font-size: 16pt;
        margin: 0 0 10px 0;
        padding-bottom: 5px;
        border-bottom: 1px solid #ddd;
    }
    .patient-info {
        margin-bottom: 5px;
    }
    .patient-info .label {
        font-weight: bold;
        display: inline-block;
        width: 100px;
    }
    .patient-info .value {
        display: inline-block;
    }
    .gejala-list {
        list-style-type: disc;
        margin: 0;
        padding-left: 20px;
    }
    .gejala-list li {
        margin-bottom: 5px;
    }
    .diagnosa-section {
        margin-top: 15px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }
    th {
        background-color: #4a7aff;
        color: white;
        padding: 10px;
        text-align: left;
    }
    td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
        vertical-align: top;
    }
    tr:nth-child(even) {
        background-color: #f2f8ff;
    }
    .percentage-cell {
        text-align: center;
        font-weight: bold;
        width: 100px;
    }
    .penyakit-cell {
        width: 150px;
    }
    .solusi-cell {
        line-height: 1.4;
    }
    .footer {
        margin-top: auto;
        border-top: 1px solid #ddd;
        padding: 10px;
        font-size: 10pt;
        text-align: center;
        color: #777;
    }
    .additional-info {
        margin-top: 20px;
        padding: 15px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 5px;
    }
    .info-title {
        font-weight: bold;
        margin-bottom: 10px;
        color: #4a7aff;
    }
    .info-content {
        line-height: 1.5;
    }
</style>

<div class="container">
    <div class="header">
        <h1>HASIL KONSULTASI</h1>
    </div>
    
    <div class="content">
        <div class="two-columns">
            <div class="column">
                <h2>Data Pasien</h2>
                <div class="patient-info"><span class="label">Nama:</span> <span class="value">' . $konsultasi['nama'] . '</span></div>
                <div class="patient-info"><span class="label">Umur:</span> <span class="value">' . $konsultasi['umur'] . ' Tahun</span></div>
                <div class="patient-info"><span class="label">Berat Badan:</span> <span class="value">' . $konsultasi['b_badan'] . ' KG</span></div>
                <div class="patient-info"><span class="label">Tinggi Badan:</span> <span class="value">' . $konsultasi['t_badan'] . ' CM</span></div>
            </div>
            
            <div class="column">
                <h2>Gejala yang Dirasakan</h2>
                <ul class="gejala-list">';
foreach ($gejala as $g) {
    $html .= '<li>' . $g . '</li>';
}
$html .= '</ul>
            </div>
        </div>
        
        <div class="diagnosa-section">
            <h2>Hasil Diagnosa</h2>
            <table>
                <thead>
                    <tr>
                        <th class="penyakit-cell">Nama Penyakit</th>
                        <th class="percentage-cell">Persentase</th>
                        <th>Solusi dan Rekomendasi</th>
                    </tr>
                </thead>
                <tbody>';

foreach ($penyakit as $p) {
    $html .= '<tr>';
    $html .= '<td class="penyakit-cell"><strong>' . $p['nmpenyakit'] . '</strong></td>';
    $html .= '<td class="percentage-cell">' . $p['persentase'] . '%</td>';
    $html .= '<td class="solusi-cell">' . $p['solusi'] . '</td>';
    $html .= '</tr>';
}

$html .= '</tbody>
            </table>
        </div>';

// Tambahkan bagian informasi tambahan untuk mengisi ruang kosong
if (count($penyakit) > 0) {
    $topDisease = $penyakit[0]['nmpenyakit'];
    
    $html .= '<div class="additional-info">
        <div class="info-title">Informasi Tambahan</div>
        <div class="info-content">
            <p>Berdasarkan gejala yang Anda laporkan, sistem pakar telah mengidentifikasi kemungkinan tertinggi yaitu <strong>' . $topDisease . '</strong>. Hasil diagnosa ini menggunakan metode perhitungan berdasarkan gejala-gejala yang Anda pilih.</p>
            <p>Direkomendasikan untuk melakukan pemeriksaan lebih lanjut dengan dokter spesialis untuk konfirmasi diagnosa dan mendapatkan penanganan yang tepat. Apabila gejala bertambah parah, segera konsultasikan dengan tenaga medis.</p>
        </div>
    </div>';
}

$html .= '</div>
    
    <div class="footer">
        <p>Tanggal: ' . date('d/m/Y') . ' | Catatan: Hasil ini hanya sebagai referensi dan tidak menggantikan konsultasi dengan dokter.</p>
    </div>
</div>';

// Konversi ke PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Unduh PDF
$dompdf->stream('hasil_konsultasi.pdf', ['Attachment' => true]);
?>
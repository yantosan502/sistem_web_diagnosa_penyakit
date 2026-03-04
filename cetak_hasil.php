<?php
// PENTING: Jangan ada spasi atau enter sebelum <?php

// Matikan error display (biar gak ganggu PDF)
error_reporting(0);
ini_set('display_errors', 0);

// Pastikan tidak ada output sebelum ini
ob_start();

require 'vendor/autoload.php';
use Dompdf\Dompdf;

// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "sistem_pakar_web");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil ID konsultasi dari parameter
$idkonsultasi = isset($_GET['idkonsultasi']) ? $_GET['idkonsultasi'] : 0;

if ($idkonsultasi == 0) {
    die("ID Konsultasi tidak valid");
}

// Query hasil konsultasi
$sql = "SELECT * FROM konsultasi WHERE idkonsultasi='$idkonsultasi'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Data tidak ditemukan");
}

$konsultasi = $result->fetch_assoc();

// ========================================
// TAMBAH: FUNGSI KATEGORISASI & FORMAT
// ========================================
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

$umur = (int)$konsultasi['umur'];
$kategori_usia = kategorikan_usia($umur);
$usia_format = format_usia($umur);

// Ambil gejala-gejala yang dipilih
$gejala = [];
$sql = "SELECT gejala.nmgejala 
        FROM detail_konsultasi 
        INNER JOIN gejala ON detail_konsultasi.idgejala = gejala.idgejala 
        WHERE idkonsultasi='$idkonsultasi'";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $gejala[] = htmlspecialchars($row['nmgejala']);
}

// Ambil hasil penyakit
$penyakit = [];
$sql = "SELECT penyakit.nmpenyakit, detail_penyakit.persentase, penyakit.solusi 
        FROM detail_penyakit 
        INNER JOIN penyakit ON detail_penyakit.idpenyakit = penyakit.idpenyakit 
        WHERE idkonsultasi='$idkonsultasi'
        ORDER BY persentase DESC";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $penyakit[] = [
        'nmpenyakit' => htmlspecialchars($row['nmpenyakit']),
        'persentase' => $row['persentase'],
        'solusi' => htmlspecialchars($row['solusi'])
    ];
}

$conn->close();

// Template HTML untuk PDF
$html = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #333;
            margin: 20px;
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
            font-size: 22pt;
            font-weight: bold;
        }
        .section {
            margin-bottom: 20px;
        }
        h2 {
            color: #4a7aff;
            font-size: 14pt;
            margin: 10px 0;
            padding-bottom: 5px;
            border-bottom: 1px solid #ddd;
        }
        .info-row {
            margin-bottom: 8px;
        }
        .label {
            font-weight: bold;
            display: inline-block;
            width: 120px;
        }
        .value {
            display: inline-block;
        }
        .gejala-list {
            margin: 10px 0;
            padding-left: 20px;
        }
        .gejala-list li {
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background-color: #4a7aff;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 11pt;
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            vertical-align: top;
            font-size: 10pt;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .percentage-cell {
            text-align: center;
            font-weight: bold;
            width: 80px;
        }
        .penyakit-cell {
            width: 150px;
            font-weight: bold;
        }
        .warning-box {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 10px;
            margin: 15px 0;
        }
        .danger-box {
            background-color: #f8d7da;
            border-left: 4px solid #dc3545;
            padding: 10px;
            margin: 15px 0;
        }
        .info-box {
            background-color: #d1ecf1;
            border-left: 4px solid #17a2b8;
            padding: 10px;
            margin: 15px 0;
        }
        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            font-size: 9pt;
            text-align: center;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>HASIL KONSULTASI STUNTING</h1>
        <p style="margin: 5px 0; color: #666;">Sistem Pakar Deteksi Stunting</p>
    </div>
    
    <div class="section">
        <h2>Data Pasien</h2>
        <div class="info-row"><span class="label">Nama:</span> <span class="value">' . htmlspecialchars($konsultasi['nama']) . '</span></div>
        <div class="info-row"><span class="label">Umur:</span> <span class="value">' . $usia_format . ' (' . $umur . ' bulan)</span></div>
        <div class="info-row"><span class="label">Kategori Usia:</span> <span class="value">' . $kategori_usia . '</span></div>
        <div class="info-row"><span class="label">Berat Badan:</span> <span class="value">' . htmlspecialchars($konsultasi['b_badan']) . ' KG</span></div>
        <div class="info-row"><span class="label">Tinggi Badan:</span> <span class="value">' . htmlspecialchars($konsultasi['t_badan']) . ' CM</span></div>
        <div class="info-row"><span class="label">Tanggal:</span> <span class="value">' . date('d/m/Y', strtotime($konsultasi['tgl'])) . '</span></div>
    </div>
    
    <div class="section">
        <h2>Gejala yang Dipilih</h2>
        <ul class="gejala-list">';

foreach ($gejala as $g) {
    $html .= '<li>' . $g . '</li>';
}

$html .= '</ul>
    </div>
    
    <div class="section">
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
    $html .= '<td class="penyakit-cell">' . $p['nmpenyakit'] . '</td>';
    $html .= '<td class="percentage-cell">' . number_format($p['persentase'], 1) . '%</td>';
    $html .= '<td>' . $p['solusi'] . '</td>';
    $html .= '</tr>';
}

$html .= '</tbody>
        </table>
    </div>';

// Tambahkan catatan penting
if (count($penyakit) > 0) {
    $topDisease = $penyakit[0]['nmpenyakit'];
    $percentage = $penyakit[0]['persentase'];
    
    $html .= '<div class="section">
        <h2>Catatan Penting</h2>
        
        <div class="info-box">
            <p style="margin: 0;">Berdasarkan gejala yang dilaporkan, sistem mengidentifikasi kemungkinan tertinggi adalah <strong>' . $topDisease . '</strong> dengan tingkat keyakinan <strong>' . number_format($percentage, 1) . '%</strong>.</p>
        </div>
        
        <div class="danger-box">
            <strong>PENTING:</strong> Hasil diagnosis sistem ini bersifat <strong>SKRINING AWAL</strong> dan <strong>BUKAN DIAGNOSIS MEDIS FINAL</strong>.
        </div>
        
        <div class="warning-box">
            <strong>REKOMENDASI:</strong> Sangat disarankan untuk melakukan pemeriksaan lebih lanjut dengan <strong>dokter spesialis anak atau ahli gizi</strong> untuk konfirmasi diagnosis yang akurat.
        </div>
    </div>';
}

$html .= '<div class="footer">
        <p><strong>Disclaimer:</strong> Hasil ini hanya sebagai referensi awal dan tidak menggantikan konsultasi medis profesional.</p>
        <p style="margin-top: 5px;"><strong>Kontak Darurat:</strong> Puskesmas terdekat | Hotline Stunting: 119 ext 9</p>
    </div>
</body>
</html>';

// Bersihkan output buffer
ob_end_clean();

// Konversi ke PDF
try {
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    
    // Output PDF
    $dompdf->stream('Hasil_Konsultasi_' . $idkonsultasi . '.pdf', [
        'Attachment' => true
    ]);
    
} catch (Exception $e) {
    die('Error generating PDF: ' . $e->getMessage());
}

?>

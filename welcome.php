<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Deteksi Stunting</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="text-center mb-4">
            <h1 class="fw-bold">Selamat Datang</h1>
            <h3>Sistem Pakar Deteksi Penyakit Stunting Pada Anak</h3>
            <h3>Metode Forward Chaining</h3>
        </div>

        <!-- Artikel Section -->
        <section class="container my-5">
            <div class="row mb-4">
                <div class="col-12">
                    <h2 class="fw-bold text-center">Artikel Kesehatan Terkini</h2>
                    <p class="text-center text-muted">Informasi lengkap seputar stunting dan kesehatan anak</p>
                </div>
            </div>

            <!-- 3 Artikel Sejajar -->
            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <img src="images/gambar 1.jpg" class="card-img-top" alt="Artikel 1" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-primary rounded-pill px-3 py-2">Informasi Dasar</span>
                                <small class="text-muted"><i class="far fa-calendar-alt me-1"></i> 12 Mar 2025</small>
                            </div>
                            <h5 class="card-title fw-bold">Apa Itu Stunting?</h5>
                            <p class="card-text" style="text-align: justify;">Stunting adalah kondisi gagal tumbuh pada anak akibat kekurangan gizi dalam waktu lama. Kondisi ini berdampak pada kesehatan, kognitif, dan produktivitas anak di masa depan.</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <a href="artikel_1.html" class="btn btn-outline-primary rounded-pill px-4">Baca Selengkapnya</a>
                                <div>
                                    <i class="far fa-eye me-1"></i> 523
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <img src="images/gambar 2.jpg" class="card-img-top" alt="Artikel 2" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-danger rounded-pill px-3 py-2">Penting</span>
                                <small class="text-muted"><i class="far fa-calendar-alt me-1"></i> 10 Mar 2025</small>
                            </div>
                            <h5 class="card-title fw-bold">Penyebab Stunting</h5>
                            <p class="card-text" style="text-align: justify;">Stunting dapat terjadi karena kurangnya asupan nutrisi, pola hidup yang kurang sehat, sanitasi buruk, dan faktor sosial ekonomi yang mempengaruhi pola asuh anak.</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <a href="artikel_2.html" class="btn btn-outline-primary rounded-pill px-4">Baca Selengkapnya</a>
                                <div>
                                    <i class="far fa-eye me-1"></i> 487
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <img src="images/gambar 4.jpg" class="card-img-top" alt="Artikel 3" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-success rounded-pill px-3 py-2">Pencegahan</span>
                                <small class="text-muted"><i class="far fa-calendar-alt me-1"></i> 5 Mar 2025</small>
                            </div>
                            <h5 class="card-title fw-bold">Cara Mencegah Stunting</h5>
                            <p class="card-text" style="text-align: justify;">Pencegahan stunting meliputi pemberian ASI eksklusif, makanan bergizi seimbang, imunisasi lengkap, dan pemantauan tumbuh kembang anak secara berkala.</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <a href="artikel_3.html" class="btn btn-outline-primary rounded-pill px-4">Baca Selengkapnya</a>
                                <div>
                                    <i class="far fa-eye me-1"></i> 612
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Area Fungsional (Pencarian, Kategori, Artikel Populer) -->
            <div class="row g-4">
                <!-- Pencarian -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary text-white py-3">
                            <h5 class="mb-0"><i class="fas fa-search me-2"></i>Cari Artikel</h5>
                        </div>
                        <div class="card-body">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Kata kunci...">
                                <button class="btn btn-primary" type="button">Cari</button>
                            </div>
                            <div class="mt-3">
                                <p class="mb-2">Pencarian populer:</p>
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="#" class="badge bg-light text-dark text-decoration-none p-2">ASI eksklusif</a>
                                    <a href="#" class="badge bg-light text-dark text-decoration-none p-2">MPASI</a>
                                    <a href="#" class="badge bg-light text-dark text-decoration-none p-2">Gizi seimbang</a>
                                    <a href="#" class="badge bg-light text-dark text-decoration-none p-2">Tumbuh kembang</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kategori -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary text-white py-3">
                            <h5 class="mb-0"><i class="fas fa-tags me-2"></i>Kategori</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-2">
                                <a href="#" class="btn btn-sm btn-outline-primary rounded-pill">Informasi Dasar</a>
                                <a href="#" class="btn btn-sm btn-outline-primary rounded-pill">Pencegahan</a>
                                <a href="#" class="btn btn-sm btn-outline-primary rounded-pill">Gizi</a>
                                <a href="#" class="btn btn-sm btn-outline-primary rounded-pill">Perkembangan Anak</a>
                                <a href="#" class="btn btn-sm btn-outline-primary rounded-pill">Penelitian</a>
                                <a href="#" class="btn btn-sm btn-outline-primary rounded-pill">Tips Orang Tua</a>
                                <a href="#" class="btn btn-sm btn-outline-primary rounded-pill">Kesehatan</a>
                                <a href="#" class="btn btn-sm btn-outline-primary rounded-pill">Pengasuhan</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Artikel Populer -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary text-white py-3">
                            <h5 class="mb-0"><i class="fas fa-star me-2"></i>Artikel Populer</h5>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex p-3">
                                    <img src="images/gambar 1.jpg" alt="Artikel Populer 1" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                    <div>
                                        <h6 class="mb-1">Mengenal Gejala Awal Stunting pada Balita</h6>
                                        <small class="text-muted">
                                            <i class="far fa-calendar-alt me-1"></i> 1 Mar 2025
                                            <i class="far fa-eye ms-2 me-1"></i> 845
                                        </small>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex p-3">
                                    <img src="images/gambar 2.jpg" alt="Artikel Populer 2" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                    <div>
                                        <h6 class="mb-1">Menu Makanan Bergizi untuk Cegah Stunting</h6>
                                        <small class="text-muted">
                                            <i class="far fa-calendar-alt me-1"></i> 28 Feb 2025
                                            <i class="far fa-eye ms-2 me-1"></i> 712
                                        </small>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="card-footer bg-white text-center">
                            <a href="artikel.html" class="text-decoration-none">Lihat Semua Artikel <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <a href="artikel.html" class="btn btn-primary rounded-pill px-4 py-2">Jelajahi Semua Artikel</a>
            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
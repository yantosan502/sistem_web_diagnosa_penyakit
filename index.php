<?php
ob_start();
session_start();
// koneksi database
include "config.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Stunting</title>
    <link rel="icon" type="logo/png" href="logo/logokes.png">

    <!-- bootstrap css -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- datatables css -->
    <link rel="stylesheet" href="assets/css/datatables.min.css">
    <!-- font awesome css -->
    <link rel="stylesheet" href="assets/css/all.css">
    <!-- choosen css -->
    <link rel="stylesheet" href="assets/css/bootstrap-chosen.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
</head>

<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-sm bg-primary navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-plus mr-2"></i> E-Stunting
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($page == "") ? 'active' : ''; ?>" href="index.php">
                            <i class="fas fa-home mr-1"></i> Home
                        </a>
                    </li>

                    <!-- setting hak akses -->
                    <?php
                    if (isset($_SESSION['role']) && $_SESSION['role'] == "Dokter") {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($page == "users") ? 'active' : ''; ?>" href="?page=users">
                                <i class="fas fa-users mr-1"></i> Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($page == "aturan") ? 'active' : ''; ?>" href="?page=aturan">
                                <i class="fas fa-book-medical mr-1"></i> Basis Aturan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($page == "konsultasiadm") ? 'active' : ''; ?>" href="?page=konsultasiadm">
                                <i class="fas fa-comments mr-1"></i> Konsultasi
                            </a>
                        </li>

                    <?php
                    } elseif (isset($_SESSION['role']) && $_SESSION['role'] == "Admin") {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link text-white <?php echo ($page == "dashboard") ? 'active' : ''; ?>" href="?page=dashboard">
                                <i class="fas fa-chart-pie mr-1"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white <?php echo ($page == "users") ? 'active' : ''; ?>" href="?page=users">
                                <i class="fas fa-user mr-1"></i> Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white <?php echo ($page == "gejala") ? 'active' : ''; ?>" href="?page=gejala">
                                <i class="fas fa-list-ul mr-1"></i> Gejala
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white <?php echo ($page == "penyakit") ? 'active' : ''; ?>" href="?page=penyakit">
                                <i class="fas fa-virus mr-1"></i> Penyakit
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white <?php echo ($page == "aturan") ? 'active' : ''; ?>" href="?page=aturan">
                                <i class="fas fa-book-medical mr-1"></i> Basis Aturan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white <?php echo ($page == "konsultasiadm") ? 'active' : ''; ?>" href="?page=konsultasiadm">
                                <i class="fas fa-comments mr-1"></i> Detail Konsultasi
                            </a>
                        </li>
                    <?php
                    } else {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link text-white <?php echo ($page == "konsultasi") ? 'active' : ''; ?>" href="?page=konsultasi">
                                <i class="fas fa-comment-medical mr-1"></i> Konsultasi
                            </a>
                        </li>
                    <?php
                    }
                    ?>
                </ul>

                <!-- User menu -->
                <ul class="navbar-nav ml-auto">
                    <?php if (isset($_SESSION['username'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown">
                                <i class="fas fa-user-circle mr-1"></i> <?php echo $_SESSION['username']; ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="dropdown-item text-muted">
                                    <i class="fas fa-id-badge mr-1"></i> <?php echo isset($_SESSION['role']) ? $_SESSION['role'] : 'User'; ?>
                                </div>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="?page=logout">
                                    <i class="fas fa-sign-out-alt mr-1"></i> Logout
                                </a>
                            </div>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">
                                <i class="fas fa-sign-in-alt mr-1"></i> Login
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- cek status login -->
    <?php
    if ($_SESSION['status'] != "y") {
        header("Location:login.php");
    }
    ?>

    <!-- container -->
    <div class="container mt-2 mb-2">
        <!-- setting menu -->
        <?php
        $page = isset($_GET['page']) ? $_GET['page'] : "";
        $action = isset($_GET['action']) ? $_GET['action'] : "";

        if ($page == "") {
            include "welcome.php";
        } elseif ($page == "dashboard") {
            include "dashboard/tampil_dashboard.php";
        } elseif ($page == "gejala") {
            if ($action == "") {
                include "gejala/tampil_gejala.php";
            } elseif ($action == "tambah") {
                include "gejala/tambah_gejala.php";
            } elseif ($action == "update") {
                include "gejala/update_gejala.php";
            } else {
                include "gejala/hapus_gejala.php";
            }
        } elseif ($page == "penyakit") {
            if ($action == "") {
                include "penyakit/tampil_penyakit.php";
            } elseif ($action == "tambah") {
                include "penyakit/tambah_penyakit.php";
            } elseif ($action == "update") {
                include "penyakit/update_penyakit.php";
            } else {
                include "penyakit/hapus_penyakit.php";
            }
        } elseif ($page == "aturan") {
            if ($action == "") {
                include "aturan/tampil_aturan.php";
            } elseif ($action == "tambah") {
                include "aturan/tambah_aturan.php";
            } elseif ($action == "detail") {
                include "aturan/detail_aturan.php";
            } elseif ($action == "update") {
                include "aturan/update_aturan.php";
            } elseif ($action == "hapus_gejala") {
                include "aturan/hapus_detail_aturan.php";
            } else {
                include "aturan/hapus_aturan.php";
            }
        } elseif ($page == "konsultasi") {
            if ($action == "") {
                include "konsultasi/tampil_konsultasi.php";
            } else {
                include "konsultasi/hasil_konsultasi.php";
            }
        } elseif ($page == "konsultasiadm") {
            if ($action == "") {
                include "konsultasi_adm/tampil_konsultasi_adm.php";
            } else {
                include "konsultasi_adm/detail_konsultasi_adm.php";
            }
        } elseif ($page == "users") {
            if ($action == "") {
                include "users/tampil_users.php";
            } elseif ($action == "tambah") {
                include "users/tambah_users.php";
            } elseif ($action == "update") {
                include "users/update_users.php";
            } else {
                include "users/hapus_users.php";
            }
        } else {
            include "logout.php";
        }
        ?>

    </div>

    <!-- jquery -->
    <script src="assets/js/jquery-3.7.0.min.js"></script>
    <!-- bootstrap js -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- datatables js -->
    <script src="assets/js/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
    <!-- font awesome js -->
    <script src="assets/js/all.js"></script>
    <!-- chosen js -->
    <script src="assets/js/chosen.jquery.min.js"></script>
    <script>
        $(function() {
            $('.chosen').chosen();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>

    <!-- Script untuk welcome message -->
    <?php if (isset($_SESSION['welcome_message']) && $_SESSION['welcome_message'] === true): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Selamat datang, <?php echo $_SESSION['username']; ?>!',
                text: 'Anda berhasil login sebagai <?php echo $_SESSION['role']; ?>.',
                position: 'top-center',
                showConfirmButton: false,
                timer: 2500
            });
        </script>
    <?php unset($_SESSION['welcome_message']);
    endif; ?>
</body>
</html>

<!-- Proses login disini -->
<?php
session_start();
require "config.php";

if (isset($_POST["submit"])) {

    // mengambil data dari form
    $username = $_POST["username"];
    $pass = md5($_POST["pass"]);

    // cek username & password
    $sql = "SELECT*FROM users where username='$username' and pass='$pass'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    if ($result->num_rows > 0) {

        // jika login berhasil
        // membuat session
        $_SESSION['username'] = $row["username"];
        $_SESSION['role'] = $row["role"];
        $_SESSION['status'] = "y";

        // session welcome message
        $_SESSION['welcome_message'] = true;

        header("Location:index.php");
    } else {
        // jika login gagal
        header("Location:?msg=n");
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LOGIN</title>

    <link rel="icon" type="logo/png" href="logo/logokes.png">
    <!-- bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="bg-light d-flex justify-content-center align-items-center" style="height: 100vh;">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <!-- Alert Login Gagal -->
                <?php if (isset($_GET['msg']) && $_GET['msg'] == "n") { ?>
                    <div class="alert alert-danger alert-dismissible fade show text-center shadow-sm mt-3" role="alert">
                        <i class="fas fa-exclamation-triangle"></i> <strong>Login Gagal!</strong> Username atau password salah.
                        <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>

                <form method="POST">
                    <div class="card border-0 shadow-sm mt-2">
                        <div class="card-header bg-success text-center text-light">
                            <h4 class="mb-0"><strong>Login</strong></h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label for="username" class="form-label">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-success">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" id="username" class="form-control border-success" name="username" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-success">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" id="password" class="form-control border-success" name="pass" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success" name="submit">Login</button>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <small class="text-muted">&copy; 2025 By Yanto</small>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- jquery -->
    <script src="assets/js/jquery-3.7.0.min.js"></script>
    <!-- bootstrap js -->
    <script src="assets/js/bootstrap.min.js"></script>
</body>


</html>
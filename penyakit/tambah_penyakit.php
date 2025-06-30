<?php
// proses tambah data
if (isset($_POST['simpan'])) {
    // mengambil data dari form
    $nmpenyakit = $_POST['nmpenyakit'];
    $ket = $_POST['ket'];
    $solusi = $_POST['solusi'];

    // proses simpan
    $sql = "INSERT INTO penyakit VALUES (Null, '$nmpenyakit', '$ket', '$solusi')";
    if ($conn->query($sql) === TRUE) {
        header("Location:?page=penyakit");
    }
}
?>

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
                        <div class="card-header bg-primary text-white border-dark mt-5"><strong>Tambah Data Penyakit</strong></div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Nama Penyakit</label>
                                <input type="text" class="form-control" name="nmpenyakit" maxlength="50" required>
                            </div>
                            <div class="form-group">
                                <label for="">Keterangan</label>
                                <input type="text" class="form-control" name="ket" maxlength="200" required>
                            </div>
                            <div class="form-group">
                                <label for="">Solusi</label>
                                <input type="text" class="form-control" name="solusi" maxlength="200" required>
                            </div>
                            <input class="btn btn-success" type="submit" name="simpan" value="Simpan">
                            <a class="btn btn-danger" href="?page=penyakit">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
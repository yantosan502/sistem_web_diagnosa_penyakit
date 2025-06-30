<?php

if (isset($_POST['simpan'])) {

    // mengambil data dari form
    $nmpenyakit = $_POST['nmpenyakit'];

    // validasi nama penyakit
    $sql = "SELECT basis_aturan.idaturan,basis_aturan.idpenyakit,penyakit.nmpenyakit 
            FROM basis_aturan INNER JOIN penyakit 
            ON basis_aturan.idpenyakit=penyakit.idpenyakit WHERE nmpenyakit='$nmpenyakit'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
?>
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Data basis aturan tersebut sudah ada</strong>
        </div>
<?php
    } else {

        // mengambil data penyakit
        $sql = "SELECT * FROM penyakit WHERE nmpenyakit='$nmpenyakit'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $idpenyakit = $row['idpenyakit'];

        // proses simpan basis aturan
        $sql = "INSERT INTO basis_aturan VALUES (Null,'$idpenyakit')";
        mysqli_query($conn, $sql);

        // mengambil idgejala
        $idgejala = $_POST['idgejala'];

        // proses ambil data aturan
        $sql = "SELECT * FROM basis_aturan ORDER BY idaturan DESC";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $idaturan = $row['idaturan'];

        // proses simpan detail basis aturan
        $jumlah = count($idgejala);
        $i = 0;
        while ($i < $jumlah) {
            $idgejalane = $idgejala[$i];
            $sql = "INSERT INTO detail_basis_aturan VALUES ($idaturan,'$idgejalane')";
            mysqli_query($conn, $sql);
            $i++;
        }
        header("Location:?page=aturan");
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
            <form action="" method="POST" name="Form" onsubmit="return validasiForm()">
                <div class="card border-dark">
                    <div class="card">
                        <div class="card-header bg-primary text-white border-dark mt-5"><strong>Tambah Basis Aturan</strong></div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Nama Penyakit</label>
                                <select class="form-control chosen" data-placeholder="Pilih Nama Penyakit" name="nmpenyakit">
                                    <option value=""></option>
                                    <?php
                                    $sql = "SELECT * FROM penyakit ORDER BY nmpenyakit ASC";
                                    $result = $conn->query($sql);
                                    while ($row = $result->fetch_assoc()) {
                                    ?>
                                        <option value="<?php echo $row['nmpenyakit']; ?>"><?php echo $row['nmpenyakit']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Tabel data gejala -->
                            <div class="form-group">
                                <label for="">Pilih Gejala Berikut:</label>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="30px"></th>
                                            <th width="30px">No</th>
                                            <th width="700px">Nama Gejala</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $sql = "SELECT*FROM gejala ORDER BY nmgejala ASC";
                                        $result = $conn->query($sql);
                                        while ($row = $result->fetch_assoc()) {
                                        ?>
                                            <tr>
                                                <td align="center"><input type="checkbox" class="check-item" name="<?php echo 'idgejala[]'; ?>" value="<?php echo $row['idgejala']; ?>"></td>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $row['nmgejala']; ?></td>
                                            </tr>
                                        <?php
                                        }
                                        $conn->close();
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <input class="btn btn-success" type="submit" name="simpan" value="Simpan">
                            <a class="btn btn-danger" href="?page=aturan">Batal</a>
                        </div>
                    </div>
            </form>
        </div>
    </div>

    <script type="text/javascript">
        function validasiForm() {
            // validasi nama penyakit
            var nmpenyakit = document.forms["Form"]["nmpenyakit"].value;

            if (nmpenyakit == "") {
                alert("Pilih nama penyakit");
                return false;
            }

            // validasi gejala yang belum dipilih
            var checkbox = document.getElementsByName('<?php echo 'idgejala[]'; ?>');

            var isChecked = false;

            for (var i = 0; i < checkbox.length; i++) {
                if (checkbox[i].checked) {
                    isChecked = true;
                    break;
                }
            }

            // jika belum ada yang dicek
            if (!isChecked) {
                alert('Pilih setidaknya satu gejala!');
                return false;
            }

            return true;

        }
    </script>
</body>
</html>
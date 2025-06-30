<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
    <div class="card">
        <div class="card-header bg-primary text-white border-dark mt-5"><strong>Data Hasil Konsultasi</strong></div>
        <div class="card-body">
            <table class="table table-bordered" id="myTable">
                <thead>
                    <tr>
                        <th width="50px">No</th>
                        <th width="150px">Tanggal</th>
                        <th width="300px">Nama Pasien</th>
                        <th width="200px">Umur (Tahun)</th>
                        <th width="250px">Berat Badan (KG)</th>
                        <th width="250px">Tinggi Badan (CM)</th>
                        <th width="100px"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $sql = "SELECT * FROM konsultasi ORDER BY tanggal DESC, nama ASC";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $row['tanggal']; ?></td>
                            <td><?php echo $row['nama']; ?></td>
                            <td><?php echo $row['umur']; ?></td>
                            <td><?php echo $row['b_badan']; ?></td>
                            <td><?php echo $row['t_badan']; ?></td>
                            <td align="center">
                                <a class="btn btn-primary" href="?page=konsultasiadm&action=detail&id=<?php echo $row['idkonsultasi']; ?>">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
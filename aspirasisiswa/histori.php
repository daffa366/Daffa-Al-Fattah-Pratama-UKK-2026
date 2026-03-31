<?php
session_start();
include 'db.php';

if ($_SESSION['status_login'] != true) {
    echo "<script>window.location='login.php'</script>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Histori Aspirasi | Admin</title>

<link rel="stylesheet" href="style.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body>

<div class="header">
    <img src="img/logo.png" class="logo-header">
    <div>
        <h2>SMKN 5 Telkom</h2>
        <p>Banda Aceh</p>
    </div>
</div>

<div class="container">

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="dashboard-admin.php">Dashboard</a>
        <a href="update-aspirasi-admin.php">Proses</a>
        <a href="histori.php">Histori</a>
        <a href="keluar.php">Logout</a>
    </div>

    <!-- Konten -->
    <div class="konten">

        <div class="card">
            <h3>Histori Aspirasi Siswa</h3>
            <p>Semua data aspirasi yang pernah masuk</p>
        </div>

        <div class="card">
            <div class="table-wrapper">
                <table class="tabel">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Kategori</th>
                            <th>Lokasi</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th>Feedback</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php 
                    $no = 1;
                    $aspirasi = mysqli_query($conn, "
                        SELECT 
                            a.*, 
                            b.status,
                            b.feedback,
                            c.ket_kategori
                        FROM tb_input_aspirasi a
                        LEFT JOIN tb_aspirasi b 
                            ON a.id_pelaporan = b.id_pelaporan
                        LEFT JOIN tb_kategori c
                            ON a.id_kategori = c.id_kategori
                        ORDER BY a.id_pelaporan DESC
                    ");

                    if(mysqli_num_rows($aspirasi) > 0){
                        while ($row = mysqli_fetch_array($aspirasi)) {

                            $status = $row['status'];

                            if($status == 'selesai'){
                                $warna = "selesai";
                            }elseif($status == 'proses'){
                                $warna = "proses";
                            }elseif($status == 'menunggu'){
                                $warna = "menunggu";
                            }else{
                                $warna = "default";
                            }
                    ?>

                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $row['nis']; ?></td>
                            <td><?php echo $row['ket_kategori']; ?></td>
                            <td><?php echo $row['lokasi']; ?></td>
                            <td><?php echo $row['tgl_input']; ?></td>
                            <td>
                                <span class="status <?php echo $warna; ?>">
                                    <?php echo $status ? ucwords($status) : 'Belum diproses'; ?>
                                </span>
                            </td>
                            <td><?php echo $row['ket']; ?></td>
                            <td><?php echo $row['feedback'] ? $row['feedback'] : '-'; ?></td>
                        </tr>

                    <?php 
                        }
                    } else {
                    ?>
                        <tr>
                            <td colspan="8" style="text-align:center;">Tidak ada data</td>
                        </tr>
                    <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

</body>
</html>
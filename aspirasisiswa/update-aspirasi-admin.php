<?php
session_start();
include 'db.php';

if ($_SESSION['status_login'] != true) {
    echo "<script>window.location='login.php'</script>";
}

// ================= UPDATE STATUS =================
if(isset($_POST['update'])){

    $id = $_POST['id_pelaporan'];
    $status = $_POST['status'];
    $feedback = mysqli_real_escape_string($conn, $_POST['feedback']);

    mysqli_query($conn, "
        UPDATE tb_aspirasi 
        SET status='$status', feedback='$feedback'
        WHERE id_pelaporan='$id'
    ");

    echo "<script>alert('Status berhasil diupdate!')</script>";
    echo "<script>window.location='';</script>";
}

// ================= AMBIL DATA =================
$aspirasi = mysqli_query($conn, "
    SELECT 
        a.id_pelaporan,
        a.nis,
        a.lokasi,
        a.ket,
        k.ket_kategori,
        b.status,
        b.feedback
    FROM tb_input_aspirasi a
    LEFT JOIN tb_aspirasi b 
        ON a.id_pelaporan = b.id_pelaporan
    LEFT JOIN tb_kategori k
        ON a.id_kategori = k.id_kategori
    ORDER BY a.id_pelaporan DESC
");

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <title>Dashboard Admin</title>
</head>

<body>

<!-- HEADER -->
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

    <!-- Content -->
    <div class="konten">

        <div class="card">
            <h3>Data Aspirasi</h3>
        </div>

        <div class="card table-wrapper">
            <table class="tabel">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NIS</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                        <th>Feedback</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                <?php while($row = mysqli_fetch_assoc($aspirasi)){ ?>

                    <tr>
                        <form method="POST">

                            <td>
                                <?= $row['id_pelaporan']; ?>
                                <input type="hidden" name="id_pelaporan" value="<?= $row['id_pelaporan']; ?>">
                            </td>

                            <td><?= $row['nis']; ?></td>
                            <td><?= $row['ket_kategori']; ?></td>
                            <td><?= $row['lokasi']; ?></td>
                            <td><?= $row['ket']; ?></td>

                            <td>
                                <select name="status" class="input-select">
                                    <option value="menunggu" <?= $row['status']=='menunggu'?'selected':''; ?>>Menunggu</option>
                                    <option value="proses" <?= $row['status']=='proses'?'selected':''; ?>>Proses</option>
                                    <option value="selesai" <?= $row['status']=='selesai'?'selected':''; ?>>Selesai</option>
                                </select>
                            </td>

                            <td>
                                <input type="text" 
                                       name="feedback" 
                                       value="<?= $row['feedback']; ?>" 
                                       class="input-text">
                            </td>

                            <td>
                                <button type="submit" name="update" class="btn-aksi biru">
                                    Update
                                </button>

                                <a href="hapus.php?hapus=<?= $row['id_pelaporan']; ?>"
                                   onclick="return confirm('Yakin ingin menghapus data ini?')"
                                   class="btn-aksi merah">
                                   Hapus
                                </a>
                            </td>

                        </form>
                    </tr>

                <?php } ?>

                </tbody>
            </table>
        </div>

    </div>
</div>

</body>
</html>
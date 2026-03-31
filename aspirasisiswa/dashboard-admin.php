<?php
    session_start();
    include 'db.php';
    if ($_SESSION['status_login']!= true) {
        echo "<script>window.location='login.php'</script>";
    }
    $query = mysqli_query($conn, "
            SELECT COUNT(*) as total_aspirasi 
            FROM tb_input_aspirasi
        ");
    $selesai = mysqli_query($conn, "
            SELECT COUNT(*) as total_selesai 
            FROM tb_aspirasi WHERE status ='selesai'
        ");
    $menunggu = mysqli_query($conn, "
            SELECT COUNT(*) as total_menunggu 
            FROM tb_aspirasi WHERE status ='menunggu'
        ");
    $proses = mysqli_query($conn, "
            SELECT COUNT(*) as total_proses 
            FROM tb_aspirasi WHERE status ='proses'
        ");

    $data = mysqli_fetch_assoc($query);
    $done = mysqli_fetch_assoc($selesai);
    $waiting = mysqli_fetch_assoc($menunggu);
    $process = mysqli_fetch_assoc($proses);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard | Aspirasi Siswa</title>
<link rel="stylesheet" type="text/css" href="style.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
</style>

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
        <a href="Histori.php">Histori</a>
        <a href="keluar.php">Logout</a>
    </div>

    <!-- Konten -->
    <div class="konten">

        <div class="card">
            <h3>Selamat datang, <?php echo $_SESSION['a_global']->username ?>!! </h3>
        </div>

        <div class="statistik">
            <div class="box-stat">
                <h1><?php echo $data['total_aspirasi']; ?></h1>
                <p>Total Aspirasi</p>
            </div>
            <div class="box-stat">
                <h1><?php echo $waiting['total_menunggu']; ?></h1>
                <p>Menunggu</p>
            </div>
            <div class="box-stat">
                <h1><?php echo $process['total_proses']; ?></h1>
                <p>Proses</p>
            </div>
            <div class="box-stat">
                <h1><?php echo $done['total_selesai']; ?></h1>
                <p>Selesai</p>
            </div>
        </div>

        <div class="card">
    <form method="GET" class="form-filter">

        <input type="text" name="cari" placeholder="Cari NIS / Lokasi"
        value="<?php echo isset($_GET['cari']) ? $_GET['cari'] : ''; ?>"
        class="input-text">

        <select name="status" class="input-select">
            <option value="">Semua Status</option>
            <option value="menunggu">Menunggu</option>
            <option value="proses">Proses</option>
            <option value="selesai">Selesai</option>
        </select>

        <input type="date" name="tanggal"
        value="<?php echo isset($_GET['tanggal']) ? $_GET['tanggal'] : ''; ?>"
        class="input-text">

        <button type="submit" class="tombol tombol-utama">Filter</button>

    </form>
</div>

        <?php 
        $no = 1;
        // ================= FILTER =================
$where = "WHERE 1=1";

if(isset($_GET['cari']) && $_GET['cari'] != ''){
    $cari = mysqli_real_escape_string($conn, $_GET['cari']);
    $where .= " AND (a.nis LIKE '%$cari%' OR c.ket_kategori LIKE '%$cari%')";
}

// status
if(isset($_GET['status']) && $_GET['status'] != ''){
    $status_filter = mysqli_real_escape_string($conn, $_GET['status']);
    $where .= " AND b.status = '$status_filter'";
}

// tanggal
if(isset($_GET['tanggal']) && $_GET['tanggal'] != ''){
    $tanggal = mysqli_real_escape_string($conn, $_GET['tanggal']);
    $where .= " AND DATE(a.tgl_input) = '$tanggal'";
}

// ================= QUERY =================
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
    $where
    ORDER BY 
        FIELD(b.status, 'selesai', 'proses', 'menunggu'),
        a.id_pelaporan DESC
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

        <div class="card aspirasi">
            <div class="judul-card">Aspirasi Siswa</div>

            <p><b>No:</b> <?php echo $no++; ?></p>
            <p><b>NIS:</b> <?php echo $row['nis']; ?></p>
            <p><b>Kategori:</b> <?php echo $row['ket_kategori']; ?></p>
            <p><b>Lokasi:</b> <?php echo $row['lokasi']; ?></p>
            <p><b>Tanggal:</b> <?php echo $row['tgl_input']; ?></p>

            <p>
                <b>Status:</b> 
                <span class="status <?php echo $warna; ?>">
                    <?php echo $status ? ucwords($status) : 'Belum diproses'; ?>
                </span>
            </p>

            <p><b>Keterangan:</b> <?php echo $row['ket']; ?></p>

            <p><b>Feedback:</b></p>
            <div class="feedback">
                <?php echo $row['feedback'] ? $row['feedback'] : 'Belum ada jawaban'; ?>
            </div>
        </div>

        <?php 
            }
        } else {
        ?>
        <div class="card">
            <h3>Belum Ada Aspirasi</h3>
            <p>Silakan kirim aspirasi terlebih dahulu.</p>
        </div>
        <?php } ?>

    </div>
</div>

</body>
</html>
<?php
session_start();
include 'db.php';

if ($_SESSION['status_login_siswa']!= true) {
    echo "<script>window.location='login.php'</script>";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Tambah Aspirasi</title>

<link rel="stylesheet" href="style.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
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
        <a href="dashboard-siswa.php">Dashboard</a>
        <a href="input-aspirasi.php">Aspirasi</a>
        <a href="keluar.php">Logout</a>
    </div>

    <!-- Konten -->
    <div class="konten">

        <div class="card">
            <h3>Tambahkan Aspirasi Anda</h3>
        </div>

        <div class="card">
            <form action="" method="POST" class="form-login">

                <div>
                    <p class="label">NIS</p>
                    <input type="text" 
                           name="nis" 
                           value="<?php echo $_SESSION['siswa_global']->nis; ?>" 
                           class="input-text" required>
                </div>

                <div>
                    <p class="label">Kategori</p>
                    <select name="kate" class="input-select" required>
                        <option value="">Pilih Kategori</option>
                        <?php 
                        $kat = mysqli_query($conn, "SELECT * FROM tb_kategori ORDER BY id_kategori");
                        while($kat2 = mysqli_fetch_array($kat)){
                        ?>
                        <option value="<?php echo $kat2['id_kategori'] ?>">
                            <?php echo $kat2['ket_kategori'] ?>
                        </option>
                        <?php } ?> 
                    </select>
                </div>

                <div>
                    <p class="label">Lokasi</p>
                    <input type="text" 
                           name="lokasi" 
                           class="input-text" 
                           placeholder="Masukkan lokasi" 
                           required>
                </div>

                <div>
                    <p class="label">Keterangan</p>
                    <textarea name="keterangan" 
                              class="input-text" 
                              placeholder="Tulis aspirasi..." 
                              rows="4"></textarea>
                </div>

                <button type="submit" name="submit" class="tombol tombol-utama full">
                    Kirim Aspirasi
                </button>

            </form>

            <?php 
            if (isset($_POST['submit'])) {
                 $nis = ucwords($_POST['nis']);
                 $kate = ucwords($_POST['kate']);
                 $lok = ucwords($_POST['lokasi']);
                 $keterangan = ucwords($_POST['keterangan']);

                 $insert = mysqli_query($conn, "
                    INSERT INTO tb_input_aspirasi (nis, id_kategori, lokasi, ket)
                    VALUES ('$nis', '$kate', '$lok', '$keterangan')
                ");

                $id_pelaporan = mysqli_insert_id($conn);

                mysqli_query($conn, "
                    INSERT INTO tb_aspirasi (status, id_pelaporan)
                    VALUES ('menunggu', '$id_pelaporan')
                ");

                 if ($insert) {
                     echo "<script>alert('Aspirasi berhasil ditambahkan!!')</script>";
                     echo "<script>window.location='dashboard-siswa.php'</script>";
                 } else {
                    echo "Ada kesalahan: ". mysqli_error($conn);
                 }
             } 
            ?>

        </div>

    </div>
</div>

</body>
</html>
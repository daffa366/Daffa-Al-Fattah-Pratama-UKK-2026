<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Siswa | Aspirasi Siswa</title>

  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body class="body-center">

  <div class="kotak-login">
    <img src="img/logo.png" class="logo">

    <h2 class="judul-login">Selamat Datang</h2>
    <p class="sub-login">Masuk sebagai siswa</p>

    <form action="" method="POST" class="form-login">

      <div class="input-grup">
        <img src="img/user-solid.png" class="ikon">
        <input type="text" name="nis" placeholder="Masukkan NIS" required>
      </div>

      <input type="submit" name="submit" value="Login" class="tombol tombol-utama full">

    </form>

    <a href="login.php" class="link-login">Login sebagai admin</a>

    <?php
        if(isset($_POST['submit'])){
            session_start();
            include 'db.php';
            $nis = mysqli_real_escape_string($conn, $_POST['nis']);

            $cek = mysqli_query($conn, "SELECT * FROM tb_siswa WHERE nis = '".$nis."'"); 
            if(mysqli_num_rows($cek) > 0 ){
                $d = mysqli_fetch_object($cek);
                $_SESSION['status_login_siswa'] = true;
                $_SESSION['siswa_global'] = $d;
                $_SESSION['id'] = $d->nis;
                echo '<script>window.location="dashboard-siswa.php"</script>';
            } else {
                echo '<script>alert("Login Gagal: NIS tidak terdaftar")</script>';
            }
        }
    ?>

  </div>

</body>
</html>
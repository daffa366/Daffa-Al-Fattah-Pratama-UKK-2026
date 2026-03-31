<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Aspirasi Siswa</title>

  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body class="body-center">

  <div class="kotak-login">
    <img src="img/logo.png" class="logo">

    <h2 class="judul-login">Selamat Datang</h2>
    <p class="sub-login">Masuk ke sistem aspirasi siswa</p>

    <form action="" method="POST" class="form-login">

      <div class="input-grup">
        <img src="img/user-solid.png" class="ikon">
        <input type="text" name="nama" placeholder="Masukkan Username" required>
      </div>

      <div class="input-grup">
        <img src="img/key-solid.png" class="ikon">
        <input type="password" name="pass" placeholder="Masukkan Password" required>
      </div>

      <input type="submit" name="submit" value="Login" class="tombol tombol-utama full">

    </form>

    <a href="login-siswa.php" class="link-login">Login sebagai siswa</a>

    <?php
        if(isset($_POST['submit'])){
            session_start();
            include 'db.php';
            $username = mysqli_real_escape_string($conn, $_POST['nama']);
            $password = mysqli_real_escape_string($conn, $_POST['pass']);

            $cek = mysqli_query($conn, "SELECT * FROM tb_admin WHERE username = '".$username."' AND password = '".MD5($password)."'"); 
            if(mysqli_num_rows($cek) > 0 ){
                $d = mysqli_fetch_object($cek);
                $_SESSION['status_login'] = true;
                $_SESSION['a_global'] = $d;
                $_SESSION['id'] = $d->username;
                echo '<script>window.location="dashboard-admin.php"</script>';
            } else {
                echo '<script>alert("Login Gagal: Cek username dan password anda!")</script>';
            }
        }
    ?>

  </div>

</body>
</html>
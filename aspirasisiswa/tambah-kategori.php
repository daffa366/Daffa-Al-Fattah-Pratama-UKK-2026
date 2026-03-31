<?php
    session_start();
    include 'db.php';
    if ($_SESSION['status_login']!= true) {
        echo "<script>window.location='login.php'</script>";
    }
    ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width-device-width, initial-scale=1">
	 <script src="https://cdn.tailwindcss.com"></script>
	 <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

	<title>Tambah Kategori | Aspirasi Siswa</title>
</head>
<body class="bg-[#F3F3F3] font-[Inter] min-h-screen flex flex-col">
   <div class="bg-[#00317A] p-3 text-white font-black flex">
        <img src="img/logo.png" width="60px" class="ml-2">
        <div class="ml-2 mt-1">
            <h1>SMKN 5 Telkom</h1>
            <h1>Banda Aceh</h1>
        </div>
    </div>
        <div class="flex flex-1">
            <div class="bg-white border w-[15%] p-4 mr-5">
                <ul class="ml-2">
                    <li><a href="dashboard-admin.php" class="hover:font-bold">Dashboard</a></li>
                    <li><a href="" class="hover:font-bold">Proses</a></li>
                    <li><a href="" class="hover:font-bold">Feedback</a></li>
                </ul>
            </div>
            <div class="p-2 w-full mr-2">
            <h1>Tambah kategori</h1>
            <div class="bg-white p-4 border mt-3 ">
            <form action="" method="POST">
                <input type="text" name="nama" value="" class="p-2 border w-full" required placeholder="Masukkan nama"><br>
                <input type="submit" name="submit" value="Submit" class="bg-[#00317A] text-white font-bold p-2 mt-3">
            </form>
            <?php 
            if (isset($_POST['submit'])) {
                 $nama = ucwords($_POST['nama']);
                 $insert = mysqli_query($conn, "INSERT INTO tb_kategori VALUES(null,'$nama')");
                 if ($insert) {
                     echo "<script> alert('Data berhasil ditambahkan!!')</script>";
                     echo "<script>window.location='kategori.php'</script>";
                 }else{
                    echo "Ada kesalahan, penambahan data gagal:". mysqli_error($conn);
                 }
             } ?>
            </div>
            </div>
        </div>

</body>
</html>
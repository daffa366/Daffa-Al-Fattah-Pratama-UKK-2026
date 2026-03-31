<?php
    session_start();
    include 'db.php';
    if ($_SESSION['status_login_siswa']!= true) {
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
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width-device-width, initial-scale=1">
	 <script src="https://cdn.tailwindcss.com"></script>
	 <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

	<title>Dashboard | Aspirasi Siswa</title>
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
                    <li><a href="dashboard-siswa.php" class="hover:font-bold">Dashboard</a></li>
                    <li><a href="input-aspirasi.php" class="hover:font-bold">Aspirasi</a></li>
                    <li><a href="" class="hover:font-bold">Feedback</a></li>
                    <li><a href="keluar.php" class="hover:font-bold">Log out</a></li>
                </ul>
            </div>
            <div class="p-2 w-full mr-2 pb-5">
            <h1>Dashboard</h1>
            <div class="bg-white h-fit p-2 border">
            <h1 class="font-semibold text-md">Selamat datang siswa <?php echo $_SESSION['siswa_global']-> kelas; ?>/<?php echo $_SESSION['siswa_global']-> nis ?>!!</h1>
            </div>
            <h1 class="text-center mt-5 font-bold text-md">Jumlah Aspirasi siswa</h1>
            <div class="mt-3 flex flex-wrap gap-4 justify-center h-[5%] mb-5">
                <div class="bg-[#00317A] text-center text-white p-5 w-[23%] rounded-md shadow-md mb-2 hover:scale-105 transition duration-300">
                   <h1 class="text-2xl font-bold"><?php  echo $data['total_aspirasi'];?></h1>
                   <h2 class="font-bold">Total Aspirasi</h2> 
                </div>

                <div class="bg-yellow-500 text-center text-white p-5 w-[24%] rounded-md shadow-md mb-2 hover:scale-105 transition duration-300">
                   <h1 class="text-2xl font-bold"><?php  echo $waiting['total_menunggu'];?></h1>
                   <h2 class="font-bold">Menunggu</h2> 
                </div>
    <!-- Proses -->
                <div class="bg-blue-500 text-center text-white p-5 w-[24%] rounded-md shadow-md mb-2 hover:scale-105 transition duration-300">
                   <h1 class="text-2xl font-bold"><?php echo $process['total_proses']; ?></h1>
                   <h2 class="font-bold">Proses</h2> 
                </div>

    <!-- Selesai -->
                <div class="bg-green-500 text-center text-white p-5 w-[24%] rounded-md shadow-md mb-2 hover:scale-105 transition duration-300">
                   <h1 class="text-2xl font-bold"><?php echo $done['total_selesai']; ?></h1>
                   <h2 class="font-bold">Selesai</h2> 
                </div>
            </div>
            
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
                    ?>
                               <div class="">
                                <h1 class="bg-[#00317A] text-white font-bold p-2 rounded-t-md">Aspirasi Siswa</h1>
                               <div class="bg-white p-5 mb-5 shadow rounded-b-md">
                                    <p><span class="font-semibold">No:</span> <?php echo $no++; ?></p>
                                    <p><span class="font-semibold">Nis:</span> <?php echo $row['nis']; ?></p>
                                    <p><span class="font-semibold">Kategori:</span> <?php echo $row['ket_kategori']; ?></p>
                                    <p><span class="font-semibold">Lokasi:</span> <?php echo $row['lokasi']; ?></p>
                                    <p><span class="font-semibold">Tanggal dilapor:</span> <?php echo $row['tgl_input']; ?></p>
                                    <p><span class="font-semibold">Status:</span> <?php echo ucwords($row['status']) ?></p>
                                    <p><span class="font-semibold">Keterangan:</span> <?php echo $row['ket']; ?></p>
                                    <p class="font-semibold">Feedback:</p>
                                    <div class="p-3 bg-gray-50 rounded-sm shadow mt-1">
                                        <p><?php echo $row['feedback']? $row['feedback']:'Belum ada jawaban' ;?></p>
                                    </div>
                                </div>
                        
                    
                    <?php 
                        }
                    }else{
                    ?>
                           <div class="bg-white rounded-md shadow p-8 text-center mt-5">
                            <h2 class="text-gray-500 text-lg font-semibold">Belum Ada Aspirasi</h2>
                            <p class="text-gray-400 mt-2">Silakan kirim aspirasi terlebih dahulu melalui menu Aspirasi.</p>
                            <a href="input-aspirasi.php" 
                               class="inline-block mt-4 bg-[#00317A] text-white px-5 py-2 rounded-md hover:bg-blue-800 transition duration-300">
                                Kirim Aspirasi
                            </a>
                            </div>
                    <?php
                    }
                    ?>
            </div>
        </div>

</body>
</html>
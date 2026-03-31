<?php 
include 'db.php';
if (isset($_GET['id'])) {
 	$delete = mysqli_query($conn, "DELETE FROM tb_kategori WHERE id_kategori='".$_GET['id']."' ");
 	echo "<script>window.location='kategori.php'</script>";
 }
 // ================= HAPUS DATA =================
if(isset($_GET['hapus'])){

    $id = $_GET['hapus'];

    // hapus dari tabel status dulu
    mysqli_query($conn, "
        DELETE FROM tb_aspirasi 
        WHERE id_pelaporan='$id'
    ");

    // lalu hapus dari tabel utama
    mysqli_query($conn, "
        DELETE FROM tb_input_aspirasi 
        WHERE id_pelaporan='$id'
    ");

    echo "<script>alert('Data berhasil dihapus!')</script>";
    echo "<script>window.location='dashboard-admin.php'</script>";
}
 ?>
<?php
include 'koneksi.php';
$id = $_POST['id'];
$tanggapan = $_POST['tanggapan'];
$status = $_POST['status'];

$sql = "UPDATE pengaduan SET tanggapan = '$tanggapan', status = '$status' WHERE id = $id";
mysqli_query($conn, $sql);
header("Location: petugas.php");
exit;
?>